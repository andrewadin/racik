<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::with('role')->where('id', '!=', Auth::user()->id)->get();
        $roles = Role::all();
        return view('layouts.user', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $rules = array(
            'nama' => 'required',
            'username' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
            'password' => 'required',
        );

        $messages = array(
            'nama.required' => 'Nama user belum diisi',
            'username.required' => 'Username belum diisi',
            'no_hp.required' => 'Nomor HP user belum diisi',
            'role.required' => 'Role belum dipilih',
            'password.required' => 'Password belum diisi',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('/user')
            ->with('alert', 'Terdapat kesalahan, periksa form penambahan user')
            ->withErrors($validator);
        }
        $user = new User();
        $user->name = $request->nama;
        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/user')->with('alert', 'User berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $rules = array(
            'edit_nama' => 'required',
            'edit_username' => 'required',
            'edit_nohp' => 'required',
            'edit_role' => 'required',
        );

        $messages = array(
            'edit_nama.required' => 'Nama user belum diisi',
            'edit_username.required' => 'Username belum diisi',
            'edit_nohp.required' => 'Nomor HP user belum diisi',
            'edit_role.required' => 'Role belum dipilih',
        );

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return redirect('/user')
            ->with('alert', 'Terdapat kesalahan, periksa form update user')
            ->withErrors($validator);
        }

        if($request->edit_password == NULL){
            User::updateOrInsert([
                'id' => $request->edit_id
            ],[
                'name' => $request->edit_nama,
                'username' => $request->edit_username,
                'no_hp' => $request->edit_nohp,
                'role_id' => $request->edit_role,
            ]);
        }else{
            User::updateOrInsert([
                'id' => $request->edit_id
            ],[
                'name' => $request->edit_nama,
                'username' => $request->edit_username,
                'no_hp' => $request->edit_nohp,
                'role_id' => $request->edit_role,
                'password' => Hash::make($request->edit_password),
            ]);
        }
        return redirect('/user')->with('alert', 'User berhasil diperbarui');
    }

    public function delete(Request $request)
    {
        User::where('id', $request->delete_id)->delete();
        return redirect('/user')->with('alert', 'User berhasil dihapus');
    }
}
