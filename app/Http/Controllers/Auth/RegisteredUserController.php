<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Antrian;
use App\Models\UptDaerah;
use App\Models\KategoriNPA;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Helper\Helper;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kategori_npas = KategoriNPA::All();
        $upt_daerahs = UptDaerah::All();
        $start = Carbon::now()->subYear()->startOfYear();
        $end = Carbon::now()->subYear()->endOfYear();
        $months_to_render = $start->diffInMonths($end);
        $yearStart = Carbon::now()->addYears(-10);
        $yearEnd = Carbon::now();
        $years_to_render = $yearStart->diffInYears($yearEnd);

        $dates = [];
        $years = [];
        for ($i = 0; $i <= $months_to_render; $i++) {
            $dates[] = $start->isoFormat('MMMM');
            $start->addMonth();
        }
        for ($i = 0; $i <= $years_to_render; $i++) {
            $years[] = $yearStart->isoFormat('Y');
            $yearStart->addYears();
        }
        return view('auth.register', compact('kategori_npas', 'upt_daerahs', 'dates', 'years'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $admin = User::role('Admin')->first();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'upt_daerah' => 'required',
            'no_telp' => 'required',
            'date' => 'required',
        ]);

        try{
            $user = Antrian::create([
                'nama_perusahaan' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'kategori_npa' => $request->kategori_npa,
                'id_wilayah' => $request->upt_daerah,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'alasan' => $request->alasan,
                'date' => $request->date . "-" . $request->year,
            ]);
            event(new Registered($user));
            Helper::sendWa($admin->no_telepon, "Ada pendaftar yang baru saja melakukan pendaftaran.");
            return redirect("/login")->with('success', "sukses mendaftar Silahkan tunggu akun di verifikasi");
        } catch(\Throwable $th){
            dd($th->getMessage());
            return redirect()->back()->with("error", $th->getMessage());
        }


    }
}
