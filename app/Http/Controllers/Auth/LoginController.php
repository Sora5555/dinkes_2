<?php

namespace App\Http\Controllers\Auth;

use Session,Auth;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username'=>'required',
            'password'=>'required|min:6',
        ],[
            'username.required'=>'Username tidak boleh kosong',
            'password.required'=>'password tidak boleh kosong',
            'password.min'=>'password minimal 6 angka',
        ]);
        if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
            Session::put('year', $request->tahun);
            // $role = Auth::user()->roles;
            // Log::create([
            //     'pengguna' => Auth::user()->nama,
            //     'kegiatan' => "Login"
            // ]);
            return redirect()->route('dashboard');
        }else{
            return redirect()->back()->withInput($request->all())->withErrors('email dan password salah');
        }
    }
}
