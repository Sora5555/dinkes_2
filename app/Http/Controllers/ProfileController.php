<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\Profile;
use App\Models\UptDaerah;
use App\Models\KategoriNPA;
use Illuminate\Http\Request;
use App\Models\TemplatePesan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $routeName = 'profile';
    protected $viewName = 'profile';
    protected $title = 'Pengaturan';
    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        $datas = Auth::user();

        // $wilayahs = UptDaerah::all();
        return view('profile.index', compact('title','route','datas'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $datas = User::findOrFail(Auth::user()->id);

        // $file_name = $datas->file_name;
        // $file_path = $datas->file_path;

        // $validator = $request->validate([
        //     'alamat'=>'required|string',
        //     'name'=>'required',
        //     'password'=>'confirmed',
        //     'email'=>'required|email',
        //     'no_telepon'=>'required|numeric',
        // ]);

        // if($request->has('file')){
        //     $validator = $request->validate([
        //         'file' => 'max:5000',
        //     ]);   
        // }

        // if ($request->has('file')) {
        // $file=$request->file('file');
        // $direktori=public_path().'/storage/image/';          
        // $nama_file=str_replace(' ','-',$request->file->getClientOriginalName());
        // $file_format= $request->file->getClientOriginalExtension();
        // $uploadSuccess = $request->file->move($direktori,$nama_file);
        // }



        try{
            DB::beginTransaction();
            $query = $datas->update([
                'nama'=>$request->nama,
                'nip'=>$request->nip,
            ]);
            if($request->password){
                $datas->update([
                    'password'=>Hash::make($request->password),
                ]);
            }
            // Log::create([
            //     'pengguna' => Auth::user()->name,
            //     'kegiatan' => "Edit Profil"
            // ]);
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data']);
        } catch (\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
