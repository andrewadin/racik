<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pakets = Paket::all();
        return view('paket', compact('pakets'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'summernote' => 'required',
            'harga' => 'required',
        ]);

        $paket = new Paket();
        $paket->nama_paket = $validate['nama'];
        $paket->harga = $validate['harga'];
        $paket->deskripsi = $validate['summernote'];
        $paket->save();

        return redirect('/paket')->with('status', 'Data berhasil disimpan');
    }

    public function update(Request $request)
    {
        Paket::updateOrInsert(
            ['id'=> $request->edit_paket_id],
            [
                'nama_paket' => $request->edit_nama,
                'harga' => $request->edit_harga,
                'deskripsi' => $request->edit_summernote,
            ]
            );
        
        return redirect('/paket')->with('status', 'Data berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        Paket::where('id', $request->delete_id)->delete();
        return redirect('/konsumen')->with('status', 'Data berhasil dihapus');
    }
}
