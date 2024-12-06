<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $user = User::all();

        // foreach ($user as $key => $value) {
        //     # code...
        //     $value->update([
        //         'password' => Hash::make('12345678'),
        //         'kode_skpd' => $value->IndukOpd->kd_perangkat_daerah,
        //         'alamat' => "-"
        //     ]);

        //     if($value->nama == "Admin"){
        //         $value->assignRole('Admin');
        //     } else {
        //         $value->assignRole('Operator');
        //     }
        // }

        // $user = User::create([
        //     'nama' => 'Admin',
        //     'username' => "Admin123",
        //     'password' => Hash::make("12345678"),
        //     'kode_skpd' => 1,
        //     'induk_opd_id' => 1,
        //     'level_id' => 1,
        //     'kategori_opd_id' => 1,
        //     'alamat' => 'Jl. A',
        // ]);
        // $user->assignRole("Admin");
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
