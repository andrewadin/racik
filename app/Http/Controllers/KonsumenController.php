<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsumen;

class KonsumenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $konsumens = Konsumen::all();
        return view('konsumen', compact('konsumens'));
    }

    public function get_kons($id)
    {
        $konsumen = Konsumen::where('id', $id)->get();
        return response()->json($konsumen);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'summernote' => 'required',
        ]);

        $konsumen = new Konsumen();
        $konsumen->nama = $validate['nama'];
        $konsumen->no_hp = $validate['no_hp'];
        $konsumen->alamat = $validate['summernote'];
        $konsumen->save();

        return redirect('/konsumen')->with('status', 'Data berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        Konsumen::updateOrInsert(
            ['id' => $request->edit_konsumen_id],
            [
                'nama' => $request->edit_nama,
                'no_hp' => $request->edit_nohp,
                'alamat' => $request->edit_summernote,
            ]
            );
        
        return redirect('/konsumen')->with('status', 'Data berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        Konsumen::where('id', $request->delete_id)->delete();
        return redirect('/konsumen')->with('status', 'Data berhasil dihapus');
    }
}
