<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Paket;
use App\Models\Konsumen;

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
        return view('pesanan_baru', compact('paket', 'konsumen'));
    }
}
