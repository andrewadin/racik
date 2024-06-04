<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('layouts.profile');
    }

    public function update(Request $request)
    {   
        User::updateOrInsert(
            ['id' => Auth::user()->id],
            ['name' => $request->edit_name,
            'username' => $request->edit_username,
            'no_hp' => $request->edit_nohp,
            ]
        );
        return redirect('/profile')->with('alert', 'Data berhasil diperbarui');
        
    }

    public function changePassword(Request $request)
    {   
        if (User::where('id', Auth::user()->id)->where('password', Hash::make($request->password_lama)) == True){
            User::updateOrInsert(
                ['id' => Auth::user()->id],
                ['password' => Hash::make($request->password_baru)]
            );
            return redirect('/profile')->with('status', 'Password berhasil diperbarui');
        }else{
            return redirect('/profile')->with('status', 'Password lama tidak sesuai'); 
        }
    }
}
