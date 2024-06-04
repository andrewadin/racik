<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\TipePaket;

class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pakets = Paket::with('tipe')->get();
        $tipes = TipePaket::all();
        return view('layouts.paket', compact('pakets', 'tipes'));
    }

    public function getPaket($id)
    {
        $paket = Paket::with('tipe')->where('id', $id)->get();
        return response()->json($paket);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'tipe' => 'required',
            'summernote' => 'required',
            'harga' => 'required',
        ]);

        $paket = new Paket();
        $paket->nama_paket = $validate['nama'];
        $paket->tipe_id = $validate['tipe'];
        $paket->harga = $validate['harga'];
        $paket->deskripsi = $validate['summernote'];
        $paket->save();

        return redirect('/paket')->with('alert', 'Data berhasil disimpan');
    }

    public function update(Request $request)
    {
        Paket::updateOrInsert(
            ['id'=> $request->edit_paket_id],
            [
                'nama_paket' => $request->edit_nama,
                'tipe_id' => $request->edit_tipe,
                'harga' => $request->edit_harga,
                'deskripsi' => $request->edit_summernote,
            ]
            );
        
        return redirect('/paket')->with('alert', 'Data berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        Paket::where('id', $request->delete_id)->delete();
        return redirect('/konsumen')->with('alert', 'Data berhasil dihapus');
    }
}
