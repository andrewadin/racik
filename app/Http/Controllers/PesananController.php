<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Paket;
use App\Models\Konsumen;
use App\Models\WaktuKirim;
use App\Models\TanggalKirim;
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
        $pesanan = Pesanan::with('konsumen', 'paket')->get();
        return view('layouts.pesanan', compact('pesanan'));
    }

    public function ongoing()
    {
        $now = Carbon::now()->format('Y-m-d');
        // $tgls = TanggalKirim::with('pesanan')->where('tgl_kirim', $now)->get();
        // $tgls = TanggalKirim::with(['pesanan' => function (Builder $query){
        //     $query->orderBy('waktu_id');
        // }])->where('tgl_kirim', $now)->get();
        $tgls = TanggalKirim::withAggregate('pesanan', 'waktu_id')->where('tgl_kirim', $now)->orderBy('pesanan_waktu_id')->get();
        // dd(count($tgls));
        return view('layouts.ongoing', compact('tgls'));
    }

    public function getHarian()
    {
        $now = Carbon::now()->format('Y-m-d');
        $tgls = TanggalKirim::with('pesanan')->where('created_at', $now)->get();
        $nows = Carbon::now()->format('d-m-Y');
        $rekap = 'Harian';
        $temp = 'Tanggal';
        return view('layouts.rekap_harian', compact('tgls', 'nows', 'rekap', 'temp'));
    }

    public function filterHarian(Request $request)
    {
        $rekap = 'Harian';
        $temp = 'Tanggal';
        $tgls = TanggalKirim::with('pesanan')->where('created_at', $request->filter_tgl)->get();
        $d = $request->filter_tgl[8].$request->filter_tgl[9];
        $m = $request->filter_tgl[5].$request->filter_tgl[6];
        $y = $request->filter_tgl[0].$request->filter_tgl[1].$request->filter_tgl[2].$request->filter_tgl[3];
        $filters = $d . '-' . $m . '-' . $y;
        return view('layouts.rekap_harian', compact('tgls', 'filters', 'rekap', 'temp'));
    }

    public function getBulanan()
    {
        $nows = Carbon::now()->isoFormat('MMMM');
        $nowm = Carbon::now()->format('m');
        $nowy = Carbon::now()->format('Y');
        $tgls = TanggalKirim::with('pesanan')
        ->whereMonth('created_at', $nowm)
        ->whereYear('created_at', $nowy)
        ->get();
        $rekap = 'Bulanan';
        $temp = 'Bulan';
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('layouts.rekap_harian', compact('tgls', 'nows', 'rekap', 'temp', 'bulan'));
    }

    public function filterBulanan(Request $request)
    {
        
        $nows = Carbon::now()->isoFormat('MMMM');
        $rekap = 'Bulanan';
        $temp = 'Bulan';
        $nowy = Carbon::now()->format('Y');
        $tgls = TanggalKirim::with('pesanan')
        ->whereMonth('created_at', $request->bulan)
        ->whereYear('created_at', $nowy)
        ->get();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $filters = $bulan[$request->bulan - 1];
        return view('layouts.rekap_harian', compact('tgls', 'filters', 'rekap', 'temp', 'bulan'));
    }

    public function getTahunan()
    {
        $years = range(2020, Carbon::now()->year);
        $nows = Carbon::now()->isoFormat('YYYY');
        $nowm = Carbon::now()->format('Y');
        $tgls = TanggalKirim::with('pesanan')->whereYear('created_at', $nowm)->get();
        $rekap = 'Tahunan';
        $temp = 'Tahun';
        return view('layouts.rekap_harian', compact('tgls', 'nows', 'rekap', 'temp', 'years'));
    }

    public function filterTahunan(Request $request)
    {
        $years = range(2020, Carbon::now()->year);
        $filters = $request->tahun;
        $nowm = Carbon::now()->format('Y');
        $tgls = TanggalKirim::with('pesanan')->whereYear('created_at', $request->tahun)->get();
        $rekap = 'Tahunan';
        $temp = 'Tahun';
        return view('layouts.rekap_harian', compact('tgls', 'filters', 'rekap', 'temp', 'years'));
    }

    public function baru()
    {
        $today = Carbon::now()->format('dmy-hms');
        $paket = Paket::all();
        $konsumen = Konsumen::all();
        $waktu = WaktuKirim::all();
        return view('layouts.pesanan_baru', compact('paket', 'konsumen', 'waktu', 'today'));
    }

    public function store(Request $request)
    {
        $s_tgl = explode(',', $request->tgl_pesan);
        $total = 0;
        if($request->h_khusus != null){
            $total = $request->h_khusus;
        }else{
            $total = $request->total;
        }
        if($request->id_kon != null){
            $rules = array(
                'id_kon' => 'required',
                'no_nota' => 'required',
                'konsumen_lama' => 'required',
                'paket' => 'required',
                'tgl_pesan' => 'required',
                'waktu' => 'required',
                'total' => 'required',
            );
    
            $messages = array(
                'id_kon.required' => 'Konsumen tidak ditemukan',
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
                return redirect('/pesanan/baru')
                ->withErrors($validator);
            }
            $pesanan = new Pesanan();
            $pesanan->no_nota = $request->no_nota;
            $pesanan->konsumen_id = $request->id_kon;
            $pesanan->paket_id = $request->paket;
            $pesanan->waktu_id = $request->waktu;
            $pesanan->catatan = $request->catatan;
            $pesanan->jumlah = count($s_tgl);
            $pesanan->diskon = $request->diskon;
            $pesanan->harga_tambahan = $request->hrg_tmb;
            $pesanan->total = $total;
            $pesanan->save();

            $pes = Pesanan::latest('created_at')->first();

            foreach($s_tgl as $stg){
                $tgl = new TanggalKirim();
                $tgl->pesanan_id = $pes->id;
                $tgl->tgl_kirim = $stg;
                $tgl->save();
            }
        }else{
            $rules = array(
                'no_nota' => 'required',
                'nama_konsumen' => 'required',
                'no_hp' => 'required',
                'summernote' => 'required',
                'paket' => 'required',
                'tgl_pesan' => 'required',
                'waktu' => 'required',
                'total' => 'required',
            );
    
            $messages = array(
                'no_nota.required' => 'Nomor nota tidak ditemukan',
                'nama_konsumen.required' => 'Nama konsumen belum diisi',
                'no_hp.required' => 'Nomor HP konsumen belum diisi',
                'summernote.required' => 'Alamat konsumen belum diisi',
                'paket.required' => 'Paket catering belum dipilih',
                'tgl_pesan.required' => 'Tanggal pengiriman belum diisi',
                'waktu.required' => 'Waktu pengiriman belum diisi',
                'total.required' => 'Total biaya belum terisi',
            );
    
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails())
            {
                return redirect('/pesanan/baru')
                ->withErrors($validator);
            }
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
            }

            $pesanan = new Pesanan();
            $pesanan->no_nota = $request->no_nota;
            $pesanan->konsumen_id = $idks;
            $pesanan->paket_id = $request->paket;
            $pesanan->waktu_id = $request->waktu;
            $pesanan->catatan = $request->catatan;
            $pesanan->jumlah = count($s_tgl);
            $pesanan->diskon = $request->diskon;
            $pesanan->harga_tambahan = $request->hrg_tmb;
            $pesanan->total = $total;
            $pesanan->save();

            $pes = Pesanan::latest('created_at')->first();
            
            $tgl = new TanggalKirim();
            $tgl->pesanan_id = $pes->id;
            foreach($s_tgl as $stg){
                $tgl->tgl_kirim = $stg;
            }
            $tgl->save();
        }
        return redirect('/nota' . '/' . $request->no_nota)->with('alert','Pesanan berhasil disimpan');
    }

    public function edit($no_nota)
    {
        $pesanan = Pesanan::with('paket', 'tgl_kirim', 'konsumen', 'waktu')->where('no_nota', $no_nota)->get();
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
        Pesanan::where('id', $request->delete_id)->delete();
        return redirect('/pesanan')->with('alert', 'Data berhasil dihapus');
    }
}
