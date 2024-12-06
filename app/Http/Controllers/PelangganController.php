<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\UptDaerah;
use App\Models\KategoriNPA;
use Illuminate\Http\Request;
use App\Models\KategoriIndustri;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    protected $routeName = 'pelanggan';
    protected $viewName = 'pelanggan';
    protected $title = 'Perusahaan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function data(Request $request){
        if(isset($request->id) || $request->id != ''){
            $datas = Pelanggan::find($request->id);
        }else if(isset($request->no) || $request->no != ''){
            $datas = Pelanggan::where('id_pelanggan',$request->no)->first();
        }else {
            $datas = Pelanggan::find($request->id);
        }
        
        $datas2 = Tagihan::find($request->edit);
        if(!isset($request->edit) || $request->edit == ''){
            $tagihans = Tagihan::where('pelanggan_id', $datas->id)->orderBy('created_at','desc');
        }else if(isset($request->edit) || ($request->edit != '')){
            $tagihans = Tagihan::where('pelanggan_id', $datas->id)->whereNotIn('id', [$request->edit])->where('created_at','<',$datas2->created_at)->orderBy('created_at','desc');
        }else{
            $tagihans = Tagihan::where('pelanggan_id', $datas->id)->orderBy('created_at','desc');
        }
        
        
        $jumlah_tagihan = $tagihans->count();

        // dd($jumlah_tagihan);

        if($jumlah_tagihan > 0){
            $meter_sebelumnya = $tagihans->first()->meter_penggunaan;
        }else if($jumlah_tagihan <= 0){
            $meter_sebelumnya = 0;
        }


        $data = [
            'id_pelanggan' => $datas->id_pelanggan,
            'name' => $datas->name,
            'no_telepon' => $datas->no_telepon,
            'alamat' => $datas->alamat,
            'meter_sebelumnya' => $meter_sebelumnya,
        ];

        return response()->json($data);
    }

    public function datatable()
    {
        $datas = Pelanggan::where('pelanggans.daerah_id', '=', Auth::user()->daerah_id)->join('upt_daerahs', 'upt_daerahs.id', '=', 'pelanggans.daerah_id')->join('users', 'users.id', '=', 'pelanggans.user_id');
        // dd($datas);
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->addColumn('daerah',function($data){
                return $data->nama_daerah??'-';
            })
            ->addColumn('kategori',function($data){
                return $data->kategori_npa?$data->kategori_npa->kategori:"Belum ada kategori";
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })->editColumn('email', function($data){
                return $data->email;
            })
            ->addColumn('action', function ($data) {
                $route = 'pelanggan';
                return view('layouts.includes.table-action-pelanggan',compact('data','route'));
            });

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $route = $this->routeName;
        $title = $this->title;

        $upt_daerahs = UptDaerah::all();
        $kategori_industris = KategoriNPA::all();

        return view($this->viewName.'.create',compact('route','title', 'upt_daerahs', 'kategori_industris'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $role = Role::findOrFail("2");
        
        $validator = $request->validate([
            'name' => 'required|string|max:100',
            'no_telepon'=>'string|required|max:100',
            'alamat'=>'string|required|max:255',
            'no_telepon'=>'string|required|max:100',
            'nik'=>'max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ],[
            'nik.max' => 'NIK tidak boleh lebih dari 20 angka'
        ]);

        try{
            $txt = date("Ymdhis");
            // $number = rand(0,1000);
            // $id = $txt.$number;
            $query2 = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'nik' => $request->nik,
                'alamat'=>$request->alamat,
                'daerah_id'=>Auth::user()->daerah_id,
            ]);
            $query = Pelanggan::create([
                'no_pelanggan' => $txt,
                'name' => $request->name,
                'no_telepon'=>$request->no_telepon,
                'alamat'=>$request->alamat,
                'nik'=>$request->nik,
                'kategori_industri_id'=>$request->kategori_industri,
                'user_id'=>$query2->id,
                'daerah_id'=>Auth::user()->daerah_id,
            ]);
            $query2->assignRole($role->name);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menambah Data Pelanggan"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Pelanggan : '.$query->name]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pelanggan : '.$e->getMessage()])->withErrors($request->all());
        }
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
        $datas = Pelanggan::findOrFail($id);
        return redirect()->route('user.edit',$datas->user->id);
        $title = $this->title;
        $route = $this->routeName;
        return view($this->viewName.'.edit', compact('datas','route','id','title'));
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
        $validator = $request->validate([
            'name' => 'required|string|max:100',
            'no_telepon'=>'string|required|max:100',
            'alamat'=>'string|required|max:255',
        ]);

        try{
            $query = Pelanggan::findOrFail($id);
            $query->update([
                'name' => $request->name,
                'no_telepon'=>$request->no_telepon,
                'alamat'=>$request->alamat,
                'nik'=>$request->nik,
            ]);
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Edit Data Pelanggan"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Pelanggan : '.$query->name]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Pelanggan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            $datas = Pelanggan::findOrFail($id);
            $user = $datas->user;

            $datas->delete();
            if(count($user->pelanggan) == 0){
                $user->delete();
            }
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Hapus Data Pelanggan"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Pelanggan : '.$datas->name]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Pelanggan : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    public function history_tagihan(Request $request, $id)
    {
        $datas = Pelanggan::findOrFail($id);
        $route = $this->routeName;
        return view($this->viewName.'.history_tagihan', compact('datas','route','id'));
    }

    public function datatable_history_tagihan(Request $request)
    {
        $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','pelanggans.name','tagihans.jumlah_pembayaran','tagihans.file_name','tagihans.file_path', 'tagihans.status')->where('pelanggans.id', $request->id);
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F');
            })
            ->addColumn('tahun', function ($data) {
                return $data->tanggal->format('Y');
            })
            ->addColumn('status', function ($data){
                if ($data->status == 0 || $data->status == 3) {
                    return 'Belum Diverifikasi';
                }elseif($data->status == 1){
                    return 'Terverifikasi';
                }elseif($data->status == 2){
                    return 'Lunas';
                }
            })
            ->addColumn('show_image', function ($data){
                $url = $data->file_path.''.$data->file_name;
                return view('layouts.includes.image_button',compact('data','url'));
            });

        return $datatables->make(true);
    }
}
