<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\User;
use Auth;

class NotaController extends Controller
{
    public function getNota($no_nota)
    {
        $no_admin = Auth::user()->no_hp;
        $pesanan = Pesanan::with('paket', 'tgl_kirim', 'konsumen', 'waktu')->where('no_nota', $no_nota)->get();
        $arr_pes = ['-', '-', '-', '-', '-', '-'];
        
        foreach ($pesanan as $pes){
            $no_nota = $pes->no_nota;
            $tmp_tgl = $pes->tgl_kirim;
            $nama = $pes->konsumen->nama;
            $tipe = $pes->paket->tipe->nama_tipe;
        }
        if($tipe == 'Harian' || $tipe == 'Mingguan'){
            for($i=0;$i<count($tmp_tgl);$i++){
                if($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == 'Senin'){
                    $arr_pes[0] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }elseif($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == 'Selasa'){
                    $arr_pes[1] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }elseif($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == 'Rabu'){
                    $arr_pes[2] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }elseif($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == 'Kamis'){
                    $arr_pes[3] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }elseif($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == "Jumat"){
                    $arr_pes[4] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }elseif($tmp_tgl[$i]['tgl_kirim']->isoFormat('dddd') == 'Sabtu'){
                    $arr_pes[5] = $tmp_tgl[$i]['tgl_kirim']->isoFormat('DD-MM-YYYY');
                }
            }
        }
        return view('layouts.nota', compact('pesanan', 'no_nota', 'arr_pes', 'no_admin', 'nama', 'tipe'));
    }
}
