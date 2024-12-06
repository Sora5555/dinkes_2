<?php

namespace App\Http\Controllers;

use Helper\Helper;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\Antrian;
use App\Models\KategoriNPA;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("antrian.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable()
    {

        if(Auth::user()->name == "Admin"){
            $datas = Antrian::join('upt_daerahs', "upt_daerahs.id", "=", "antrians.id_wilayah")->select("antrians.id", "antrians.nama_perusahaan", 'antrians.no_telp', "antrians.email", "upt_daerahs.nama_daerah");
        } else {
            $datas = Antrian::join('upt_daerahs', "upt_daerahs.id", "=", "antrians.id_wilayah")->where('antrians.id_wilayah', Auth::user()->daerah_id)->select("antrians.id", "antrians.nama_perusahaan", 'antrians.no_telp', "antrians.email", "upt_daerahs.nama_daerah");
        }
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $route = 'antrian';
                return view('layouts.includes.table-action-nota',compact('data','route'));
            });

        return $datatables->make(true);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Antrian::findOrFail($id);
        $daerah = $data->daerah()->first();
        $kategori = KategoriNPA::where('aktif', 1)->get();
        return view("antrian.edit", compact("data", "daerah", "kategori"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $datas = Antrian::findOrFail($id);
        $role = Role::findOrFail("2");
        try{
            $txt = date("Ymdhis");
            // $number = rand(0,1000);
            // $id = $txt.$number;
            $query2 = User::create([
                'name' => $datas->nama_perusahaan,
                'email' => $datas->email,
                'password' => $datas->password,
                'no_telepon' => $datas->no_telp,
                'nik' => "-",
                'alamat'=>$datas->alamat,
                'daerah_id'=>$datas->id_wilayah,
            ]);
            foreach($request->kategori as $key => $kategori){
                $query = Pelanggan::create([
                    'no_pelanggan' => $txt.$key,
                    'name' => $datas->nama_perusahaan,
                    'no_telepon'=>$datas->no_telp,
                    'alamat'=>$datas->alamat,
                    'nik'=>"-",
                    'kategori_industri_id'=>$kategori,
                    'lokasi'=>$request->lokasi[$key],
                    'user_id'=>$query2->id,
                    'daerah_id'=>$datas->id_wilayah,
                ]);
            }
            $query2->assignRole($role->name);
            Helper::sendWa($datas->no_telp, "akun anda telah di verifikasi dan sekarang sudah bisa digunakan untuk login ke Aplikasi PAP, Silahkan login ke link ini https://pap.kaltimprov.go.id/");
            $datas->delete();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menyetujui User Baru"
            ]);
            if(Auth::user()->roles->first()->name =='Admin'){
                return redirect(route('user.index'))->with(['success'=>'Berhasil Verifikasi Data User : '.$query->name]);
            } else {
                return redirect(route('pelanggan.index'))->with(['success'=>'Berhasil Verifikasi Data User : '.$query->name]);
            }
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pelanggan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $antrian = Antrian::findOrFail($id);
        try {
            $antrian->delete();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus Data Pendaftar"
            ]);
            return redirect()->back()->with("success", "berhasil menghapus data antrian");
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with("error", "gagal menghapus data antrian");
        }
    }
}
