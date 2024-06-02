<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Paket;
use App\Models\Konsumen;
use App\Models\WaktuKirim;
use App\Models\TanggalKirim;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pesanan = Pesanan::with('konsumen', 'paket')->get();
        return view('pesanan', compact('pesanan'));
    }

    public function baru()
    {
        $paket = Paket::all();
        $konsumen = Konsumen::all();
        $waktu = WaktuKirim::all();
        return view('pesanan_baru', compact('paket', 'konsumen', 'waktu'));
    }

    public function store(Request $request)
    {
        $s_tgl = explode(',', $request->tgl_pesan);
        $total = 0;
        if($request->h_khusus != NULL){
            $total = $request->h_khusus;
        }else{
            $total = $request->total;
        }
        if($request->id_kon != NULL){
            $pesanan = new Pesanan();
            $pesanan->konsumen_id = $request->id_kon;
            $pesanan->paket_id = $request->paket;
            $pesanan->waktu_id = $request->waktu;
            $pesanan->catatan = $request->catatan;
            $pesanan->jumlah = count($s_tgl);
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
            $konsumen = Konsumen::updateOrCreate(
                [
                    'nama' => $request->nama_konsumen
                ],[
                'nama' => $request->nama_konsumen,
                'no_hp' => $request->no_hp,
                'alamat' => $request->summernote
            ]);

            $kons = Konsumen::where('nama', $request->nama_konsumen)->get();

            $pesanan = new Pesanan();
            $pesanan->konsumen_id = $kons->id;
            $pesanan->paket_id = $request->paket;
            $pesanan->waktu_id = $request->waktu;
            $pesanan->catatan = $request->catatan;
            $pesanan->jumlah = count($s_tgl);
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
        return redirect('/pesanan')->with('alert','Pesanan berhasil disimpan');
    }
}
