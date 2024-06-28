<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Paket;
use App\Models\Konsumen;
use App\Models\WaktuKirim;
use App\Models\TanggalKirim;
use App\Models\MenuPesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PesananController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pesanan = Pesanan::with('konsumen')->get();
        return view('layouts.pesanan', compact('pesanan'));
    }

    public function ongoing()
    {
        $now = Carbon::now()->format('Y-m-d');
        $tgls = TanggalKirim::withAggregate('pesanan', 'waktu_id')
        ->where('tgl_kirim', $now)
        ->orderBy('pesanan_waktu_id')
        ->get();
        return view('layouts.ongoing', compact('tgls'));
    }

    public function getHarian()
    {
        $now = Carbon::now()->format('Y-m-d');
        $pesanan = Pesanan::with('menu')
        ->whereDate('created_at', $now)
        ->get();
        $nows = Carbon::now()->format('d-m-Y');
        $rekap = 'Harian';
        $temp = 'Tanggal';
        return view('layouts.rekap_harian', compact('pesanan', 'nows', 'rekap', 'temp'));
    }

    public function rekapLunch()
    {
        $swkt = WaktuKirim::where('waktu', 'Lunch')->get();
        $wkt = $swkt[0]["id"];
        $wktx = $swkt[0]['waktu'];
        $x = 1;
        $now = Carbon::now()->format('Y-m-d');
        $nows = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $pesanan = TanggalKirim::with('menu', 'pesanan')
        ->where('waktu_id', $wkt)
        ->where('tgl_kirim', $now)
        ->get();
        return view('layouts.rekap_kiriman', compact('pesanan', 'wktx', 'x', 'nows'));
    }

    public function rekapDinner()
    {
        $swkt = WaktuKirim::where('waktu', 'Dinner')->get();
        $wkt = $swkt[0]["id"];
        $wktx = $swkt[0]['waktu'];
        $x = 1;
        $now = Carbon::now()->format('Y-m-d');
        $nows = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $pesanan = TanggalKirim::with('menu', 'pesanan')
        ->where('waktu_id', $wkt)
        ->where('tgl_kirim', $now)
        ->get();
        return view('layouts.rekap_kiriman', compact('pesanan', 'wktx', 'x', 'nows'));
    }

    public function filterHarian(Request $request)
    {
        $rekap = 'Harian';
        $temp = 'Tanggal';
        $pesanan = Pesanan::with('menu')->whereDate('created_at', $request->filter_tgl)->get();
        $d = $request->filter_tgl[8].$request->filter_tgl[9];
        $m = $request->filter_tgl[5].$request->filter_tgl[6];
        $y = $request->filter_tgl[0].$request->filter_tgl[1].$request->filter_tgl[2].$request->filter_tgl[3];
        $filters = $d . '-' . $m . '-' . $y;
        return view('layouts.rekap_harian', compact('pesanan', 'filters', 'rekap', 'temp'));
    }

    public function getBulanan()
    {
        $nows = Carbon::now()->isoFormat('MMMM');
        $nowm = Carbon::now()->format('m');
        $nowy = Carbon::now()->format('Y');
        $pesanan = Pesanan::with('menu')
        ->whereMonth('created_at', $nowm)
        ->whereYear('created_at', $nowy)
        ->get();
        $rekap = 'Bulanan';
        $temp = 'Bulan';
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('layouts.rekap_harian', compact('pesanan', 'nows', 'rekap', 'temp', 'bulan'));
    }

    public function filterBulanan(Request $request)
    {
        $rekap = 'Bulanan';
        $temp = 'Bulan';
        $nowy = Carbon::now()->format('Y');
        $pesanan = Pesanan::with('menu')
        ->whereMonth('created_at', $request->bulan)
        ->whereYear('created_at', $nowy)
        ->get();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $filters = $bulan[$request->bulan - 1];
        return view('layouts.rekap_harian', compact('pesanan', 'filters', 'rekap', 'temp', 'bulan'));
    }

    public function getTahunan()
    {
        $years = range(2020, Carbon::now()->year);
        $nows = Carbon::now()->isoFormat('YYYY');
        $nowm = Carbon::now()->format('Y');
        $pesanan = Pesanan::with('menu')->whereYear('created_at', $nowm)->get();
        $rekap = 'Tahunan';
        $temp = 'Tahun';
        return view('layouts.rekap_harian', compact('pesanan', 'nows', 'rekap', 'temp', 'years'));
    }

    public function filterTahunan(Request $request)
    {
        $years = range(2020, Carbon::now()->year);
        $filters = $request->tahun;
        $nowm = Carbon::now()->format('Y');
        $pesanan = Pesanan::with('menu')->whereYear('created_at', $request->tahun)->get();
        $rekap = 'Tahunan';
        $temp = 'Tahun';
        return view('layouts.rekap_harian', compact('pesanan', 'filters', 'rekap', 'temp', 'years'));
    }

    public function baru()
    {
        $today = Carbon::now()->format('dmy-hms');
        $paket = Paket::all();
        $konsumen = Konsumen::all();
        $waktu = WaktuKirim::all();
        return view('layouts.pesanan_baru', compact('paket', 'konsumen', 'waktu', 'today'));
    }

    public function baru_next(Request $request)
    {
        $paket = $request->paket;
        $wkt = $request->waktu;
        $total = 0;
        $pakets = Paket::all();
        $konsumen = Konsumen::all();
        for ($i=0; $i < count($request->tgl_pesan); $i++) { 
            $tgl_pesan[$i] = explode(',', $request->tgl_pesan[$i]);
            $stipe = Paket::with('tipe')->where('id', $paket[$i])->get();
            $swt = WaktuKirim::where('id', $wkt[$i])->get();
            foreach($stipe as $tip){
                $npkt[$i] = $tip->nama_paket;
                $tipe = $tip->tipe->nama_tipe;
                $harga = $tip->harga;
                $hrg[$i] = $tip->harga;
            }
            foreach ($swt as $st){
                $waktu[$i] = $st->waktu;
            }
            if($tipe == 'Harian'){
                $total += $harga * count($tgl_pesan[$i]);
            }else if($tipe == 'Mingguan'){
                $temp = ceil(count($tgl_pesan[$i]) / 6);
                $total += $harga * $temp;
            }else if($tipe == 'Bulanan'){
                $temp = ceil(count($tgl_pesan[$i]) / 30);
                $total += $harga * $temp;
            }
            for ($j=0; $j < count($tgl_pesan[$i]); $j++) { 
                $tgl_pesan[$i][$j] = Carbon::createFromFormat('Y-m-d', $tgl_pesan[$i][$j]);
            }
        }
        $no_nota = $request->no_nota;

        if($request->konsumen_lama != NULL){
            $idks = $request->konsumen_lama;
            $nks = $request->nama_konsumen;
            $hpks = $request->no_hp;
            $alks = $request->summernote;
        }else{
            $konsumen = Konsumen::updateOrCreate(
                        [
                            'nama' => $request->nama_konsumen
                        ],[
                        'nama' => $request->nama_konsumen,
                        'no_hp' => $request->no_hp,
                        'alamat' => $request->summernote
                    ]);
            $kons = Konsumen::where('nama', $request->nama_konsumen)->get();
            foreach($kons as $ks){
                $idks = $ks->id;
                $nks = $ks->nama;
                $hpks = $ks->no_hp;
                $alks = $ks->alamat;
            }
        }
        return view('layouts.pesanan_baru_2', compact('idks', 'nks', 'hpks', 'alks', 'tgl_pesan', 'total', 'pakets', 'konsumen', 'waktu', 'no_nota', 'npkt', 'paket', 'wkt', 'hrg', 'temp'));
        // $s_tgl = explode(',', $request->tgl_pesan);
        // $total = 0;
        // if($request->h_khusus != null){
        //     $total = $request->h_khusus;
        // }else{
        //     $total = $request->total;
        // }
        // if($request->id_kon != null){
        //     $rules = array(
        //         'id_kon' => 'required',
        //         'no_nota' => 'required',
        //         'konsumen_lama' => 'required',
        //         'paket' => 'required',
        //         'tgl_pesan' => 'required',
        //         'waktu' => 'required',
        //         'total' => 'required',
        //     );
    
        //     $messages = array(
        //         'id_kon.required' => 'Konsumen tidak ditemukan',
        //         'no_nota.required' => 'Nomor nota tidak ditemukan',
        //         'konsumen_lama.required' => 'Konsumen tidak ditemukan',
        //         'paket.required' => 'Paket catering belum dipilih',
        //         'tgl_pesan.required' => 'Tanggal pengiriman belum diisi',
        //         'waktu.required' => 'Waktu pengiriman belum diisi',
        //         'total.required' => 'Total biaya belum terisi',
        //     );
    
        //     $validator = Validator::make($request->all(), $rules, $messages);
        //     if($validator->fails())
        //     {
        //         return redirect('/pesanan/baru')
        //         ->withErrors($validator);
        //     }
        //     $pesanan = new Pesanan();
        //     $pesanan->no_nota = $request->no_nota;
        //     $pesanan->konsumen_id = $request->id_kon;
        //     $pesanan->paket_id = $request->paket;
        //     $pesanan->waktu_id = $request->waktu;
        //     $pesanan->catatan = $request->catatan;
        //     $pesanan->jumlah = count($s_tgl);
        //     $pesanan->diskon = $request->diskon;
        //     $pesanan->harga_tambahan = $request->hrg_tmb;
        //     $pesanan->total = $total;
        //     $pesanan->save();

        //     $pes = Pesanan::latest('created_at')->first();

        //     foreach($s_tgl as $stg){
        //         $tgl = new TanggalKirim();
        //         $tgl->pesanan_id = $pes->id;
        //         $tgl->tgl_kirim = $stg;
        //         $tgl->save();
        //     }
        // }else{
        //     $rules = array(
        //         'no_nota' => 'required',
        //         'nama_konsumen' => 'required',
        //         'no_hp' => 'required',
        //         'summernote' => 'required',
        //         'paket' => 'required',
        //         'tgl_pesan' => 'required',
        //         'waktu' => 'required',
        //         'total' => 'required',
        //     );
    
        //     $messages = array(
        //         'no_nota.required' => 'Nomor nota tidak ditemukan',
        //         'nama_konsumen.required' => 'Nama konsumen belum diisi',
        //         'no_hp.required' => 'Nomor HP konsumen belum diisi',
        //         'summernote.required' => 'Alamat konsumen belum diisi',
        //         'paket.required' => 'Paket catering belum dipilih',
        //         'tgl_pesan.required' => 'Tanggal pengiriman belum diisi',
        //         'waktu.required' => 'Waktu pengiriman belum diisi',
        //         'total.required' => 'Total biaya belum terisi',
        //     );
    
        //     $validator = Validator::make($request->all(), $rules, $messages);
        //     if($validator->fails())
        //     {
        //         return redirect('/pesanan/baru')
        //         ->withErrors($validator);
        //     }
        //     $konsumen = Konsumen::updateOrCreate(
        //         [
        //             'nama' => $request->nama_konsumen
        //         ],[
        //         'nama' => $request->nama_konsumen,
        //         'no_hp' => $request->no_hp,
        //         'alamat' => $request->summernote
        //     ]);

        //     $kons = Konsumen::where('nama', $request->nama_konsumen)->get();
        //     foreach($kons as $ks){
        //         $idks = $ks->id;
        //     }

        //     $pesanan = new Pesanan();
        //     $pesanan->no_nota = $request->no_nota;
        //     $pesanan->konsumen_id = $idks;
        //     $pesanan->paket_id = $request->paket;
        //     $pesanan->waktu_id = $request->waktu;
        //     $pesanan->catatan = $request->catatan;
        //     $pesanan->jumlah = count($s_tgl);
        //     $pesanan->diskon = $request->diskon;
        //     $pesanan->harga_tambahan = $request->hrg_tmb;
        //     $pesanan->total = $total;
        //     $pesanan->save();

        //     $pes = Pesanan::latest('created_at')->first();
            
        //     $tgl = new TanggalKirim();
        //     $tgl->pesanan_id = $pes->id;
        //     foreach($s_tgl as $stg){
        //         $tgl->tgl_kirim = $stg;
        //     }
        //     $tgl->save();
        // }
        // return redirect('/nota' . '/' . $request->no_nota)->with('alert','Pesanan berhasil disimpan');
    }

    public function store(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'no_nota' => 'required',
            'id_kon' => 'required',
            'pkt' => 'required',
            'tgl_pesan' => 'required',
            'wkt' => 'required',
            'total' => 'required',
        );

        $messages = array(
            'id.required' => 'Pesanan tidak ditemukan',
            'no_nota.required' => 'Nomor nota tidak ditemukan',
            'id_kon.required' => 'Konsumen tidak ditemukan',
            'pkt.required' => 'Paket catering belum dipilih',
            'tgl_pesan.required' => 'Tanggal pengiriman belum diisi',
            'wkt.required' => 'Waktu pengiriman belum diisi',
            'total.required' => 'Total biaya belum terisi',
        );
        
        
        if($request->hrg_kh == NULL || $request->hrg_kh == 0){
            Pesanan::updateOrCreate([
                'no_nota' => $request->no_nota
            ], [
                'no_nota' => $request->no_nota,
                'konsumen_id' => $request->id_kon,
                'diskon' => $request->diskon,
                'harga_tambahan' => $request->hrg_tmb,
                'total' => $request->total,
            ]);
        }else{
            Pesanan::updateOrCreate([
                'no_nota' => $request->no_nota
            ], [
                'no_nota' => $request->no_nota,
                'konsumen_id' => $request->id_kon,
                'diskon' => $request->diskon,
                'harga_tambahan' => $request->hrg_tmb,
                'total' => $request->hrg_kh,
            ]);
        }

        $pes = Pesanan::where('no_nota', $request->no_nota)->get('id');
        
        for ($i=0; $i < count($request->pkt); $i++) {
            $mps = MenuPesanan::where('pesanan_id', $pes[0]['id'])->where('paket_id', $request->pkt[$i])->latest()->first();
            
            if($mps == NULL){
                $meps = new MenuPesanan();    
                $meps->pesanan_id = $pes[0]['id'];    
                $meps->paket_id = $request->pkt[$i];    
                $meps->harga = $request->hrg[$i];    
                $meps->jumlah = count($request->tgl_pesan[$i]);
                $meps->save();
                $mpps = MenuPesanan::where('pesanan_id', $pes[0]['id'])->where('paket_id', $request->pkt[$i])->latest()->first();
                $idms = $mpps->id;
            }else{
                $idms = $mps->id;
            }   
            for ($j=0; $j < count($request->tgl_pesan[$i]); $j++) { 
                $tgl_kr = new TanggalKirim();
                $tgl_kr->pesanan_id = $pes[0]['id'];        
                $tgl_kr->waktu_id = $request->wkt[$i];
                $tgl_kr->menu_id = $idms;
                $tgl_kr->tgl_kirim = $request->tgl_pesan[$i][$j];
                $tgl_kr->catatan = $request->catatan[$i][$j];
                $tgl_kr->save();
            }
        }

        return redirect('/nota' . '/' . $request->no_nota)->with('alert','Pesanan berhasil disimpan');
    }

    public function edit($no_nota)
    {
        $pesanan = Pesanan::with('tgl_kirim.waktu', 'tgl_kirim.menu')->where('no_nota', $no_nota)->get();
        dd($pesanan);
        $paket = Paket::all();
        $konsumen = Konsumen::all();
        $waktu = WaktuKirim::all();
        $s_tgl = array();
        $tgl = '';
        foreach($pesanan as $pes){
            $s_tgl = $pes->tgl_kirim;
        }
        $tgl = $s_tgl[0]["tgl_kirim"]->format('d-m-Y');
        for ($i=1; $i < count($s_tgl); $i++) { 
            $tgl = $tgl . ',' . $s_tgl[$i]["tgl_kirim"]->format('d-m-Y');
        }
        return view('layouts.edit_pesanan', compact('pesanan', 'paket', 'konsumen', 'waktu', 'tgl'));
    }

    public function update(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'no_nota' => 'required',
            'konsumen_lama' => 'required',
            'paket' => 'required',
            'tgl_pesan' => 'required',
            'waktu' => 'required',
            'total' => 'required',
        );

        $messages = array(
            'id.required' => 'Pesanan tidak ditemukan',
            'no_nota.required' => 'Nomor nota tidak ditemukan',
            'konsumen_lama.required' => 'Konsumen tidak ditemukan',
            'paket.required' => 'Paket catering belum dipilih',
            'tgl_pesan.required' => 'Tanggal pengiriman belum diisi',
            'waktu.required' => 'Waktu pengiriman belum diisi',
            'total.required' => 'Total biaya belum terisi',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('/pesanan'.'/'.$request->no_nota)
            ->withErrors($validator);
        }
        $s_tgl = explode(',', $request->tgl_pesan);
        Pesanan::updateOrCreate([
            'id' => $request->id
        ],[
            'no_nota' => $request->no_nota,
            'konsumen_id' => $request->konsumen_lama,
            'paket_id' => $request->paket,
            'waktu_id' => $request->waktu,
            'catatan' => $request->catatan,
            'jumlah' => count($s_tgl),
            'diskon' => $request->diskon,
            'harga_tambahan' => $request->hrg_tmb,
            'total' => $request->total,
        ]);

        foreach($s_tgl as $tgl){
            TanggalKirim::updateOrCreate([
                "pesanan_id" => $request->id
            ],[
                "tgl_kirim" => $tgl
            ]);
        }
        return redirect('/pesanan')->with('alert','Pesanan berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        TanggalKirim::where('pesanan_id', $request->delete_id)->delete();
        MenuPesanan::where('pesanan_id', $request->delete_id)->delete();
        Pesanan::where('id', $request->delete_id)->delete();
        return redirect('/pesanan')->with('alert', 'Data berhasil dihapus');
    }
}
