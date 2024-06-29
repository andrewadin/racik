<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\TanggalKirim;
use App\Models\User;
use Auth;

class NotaController extends Controller
{
    public function getNota($no_nota)
    {
        $spe = Pesanan::where('no_nota', $no_nota)->get();
        foreach ($spe as $sp) {
            $idps = $sp->id;
            $total = $sp->total;
            $hrg_tmb = $sp->harga_tambahan;
            $diskon = $sp->diskon;
        }
        $pesanan = TanggalKirim::with('waktu', 'pesanan', 'menu')->where('pesanan_id', $idps)->get();
        $no_admin = Auth::user()->no_hp;
        $pnm = array();
        $phr = array();
        $pjl = array();
        $ptp = array();
        $pwt = array();
        $arr_ps = [[]];
        $arr_ct = [[]];
        $bln_jml = 0;
        $spid = 0; $x = -1; $y = 0;
        foreach ($pesanan as $pes){
            $no_nota = $pes->pesanan->no_nota;
            $nama = $pes->pesanan->konsumen->nama;
            $no_hp = $pes->pesanan->konsumen->no_hp;
            $alamat = $pes->pesanan->konsumen->alamat;
            if($pes->menu->paket_id != $spid){
                $spid = $pes->menu->paket_id;
                array_push($pnm, $pes->menu->paket->nama_paket);
                array_push($phr, $pes->menu->paket->harga);
                array_push($ptp, $pes->menu->paket->tipe->nama_tipe);
                array_push($pwt, $pes->waktu->waktu);
                $x++;
                $y = 0;
                $sarr_ps[$x][$y] = $pes->tgl_kirim;
                $sarr_ct[$x][$y] = $pes->catatan;
            }else{
                $y++;
                $sarr_ps[$x][$y] = $pes->tgl_kirim;
                $sarr_ct[$x][$y] = $pes->catatan;
            }
        }
        for ($i=0; $i < count($pnm); $i++) {
            array_push($pjl, count($sarr_ps[$i]));
            if($ptp[$i] == 'Harian'){
                if(count($sarr_ps[$i]) <= 6){
                    for ($j=0; $j < 6; $j++) { 
                        $arr_ps[$i][$j] = '-';
                        $arr_ct[$i][$j] = '-';
                    }
                    for ($j=0; $j < count($sarr_ps[$i]); $j++) { 
                        if($sarr_ps[$i][$j]->isoFormat('dddd') == 'Senin'){
                            $arr_ps[$i][0] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][0] = $sarr_ct[$i][$j];
                        }elseif($sarr_ps[$i][$j]->isoFormat('dddd') == 'Selasa'){
                            $arr_ps[$i][1] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][1] = $sarr_ct[$i][$j];
                        }elseif($sarr_ps[$i][$j]->isoFormat('dddd') == 'Rabu'){
                            $arr_ps[$i][2] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][2] = $sarr_ct[$i][$j];
                        }elseif($sarr_ps[$i][$j]->isoFormat('dddd') == 'Kamis'){
                            $arr_ps[$i][3] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][3] = $sarr_ct[$i][$j];
                        }elseif($sarr_ps[$i][$j]->isoFormat('dddd') == 'Jumat'){
                            $arr_ps[$i][4] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][4] = $sarr_ct[$i][$j];
                        }elseif($sarr_ps[$i][$j]->isoFormat('dddd') == 'Sabtu'){
                            $arr_ps[$i][5] = $sarr_ps[$i][$j]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][5] = $sarr_ct[$i][$j];
                        }
                    }
                }else{
                    $wk_jml = ceil(count($sarr_ps[0]) / 6);
                    $c = 0;
                    for ($j=0; $j < $wk_jml; $j++) { 
                        for ($k=0; $k < 6; $k++) { 
                            $arr_ps[$i][$j][$k] = '-';
                            $arr_ct[$i][$j][$k] = '-';
                        }
                    }
                    for ($j=0; $j < $wk_jml; $j++) {
                        for ($k=0; $k < 6; $k++) { 
                            if($sarr_ps[$i][$c]->isoFormat('dddd') == 'Senin'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Selasa'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Rabu'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Kamis'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Jumat'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Sabtu'){
                                $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                                $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                                $c++;
                            }
                        }
                    }
                } 
            }else if($ptp[$i] == 'Mingguan'){
                $wk_jml = ceil(count($sarr_ps[0]) / 6);
                $c = 0;
                for ($j=0; $j < $wk_jml; $j++) { 
                    for ($k=0; $k < 6; $k++) { 
                        $arr_ps[$i][$j][$k] = '-';
                        $arr_ct[$i][$j][$k] = '-';
                    }
                }
                for ($j=0; $j < $wk_jml; $j++) {
                    for ($k=0; $k < 6; $k++) { 
                        if($sarr_ps[$i][$c]->isoFormat('dddd') == 'Senin'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Selasa'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Rabu'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Kamis'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Jumat'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }elseif($sarr_ps[$i][$c]->isoFormat('dddd') == 'Sabtu'){
                            $arr_ps[$i][$j][$k] = $sarr_ps[$i][$c]->isoFormat('DD-MM-YYYY');
                            $arr_ct[$i][$j][$k] = $sarr_ct[$i][$c];
                            $c++;
                        }
                    }
                }
            }else{
                $bln_jml = count($sarr_ps[0])/30;
            }
        }
        return view('layouts.nota', compact('no_nota', 'no_admin', 'nama', 'no_hp', 'alamat', 'pnm', 'phr', 'ptp', 'pjl', 'pwt', 'arr_ps', 'arr_ct', 'hrg_tmb', 'diskon', 'total', 'bln_jml'));
    }
}
