<?php

namespace App\Http\Controllers;

use Session,DB;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Models\IndukOpd;
use App\Models\Pelanggan;
use App\Models\UptDaerah;
use App\Models\KategoriNPA;
use App\Models\Menu;
use App\Models\MenuPermission;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    
    protected $routeName = 'user';
    protected $viewName = 'user';
    protected $title = 'Pengguna';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        // $datas = User::with('roles')->with('daerah')->first();
        return view($this->viewName.'.index',compact('route'));
    }


     public function datatable(Request $request)
    {
        if(Auth::user()->roles->first()->name =='Admin'){
            $datas = User::with('roles')->get();
        } else {
            $datas = User::with('roles')->get();
        }
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('roles',function($data){
                    $roles = $data->roles;
                    if(count($roles) > 0){
                        if($data->roles[0]->name == "Operator"){
                            return "Operator";
                        }
                        else if($data->roles[0]->name == "Pihak Wajib Pajak"){
                            return "Puskesmas";
                        }
                        else {
                            return $data->roles[0]->name;
                        }
                    } else {
                        return "tidak ada role";
                    }
                    
                })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) {
                $route = 'user';
                return view('layouts.includes.table-action',compact('data','route'));
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
        if (Auth::user()->roles->first()->name =='Admin') {
            $role = Role::where('name', '<>', 'Pihak Wajib Pajak')->where('name', '<>', 'pelanggan')->pluck('name','id');
        }else{
            $role = Role::where('name','<>','Admin')->pluck('name','id');
        }
        // dd(route($this->viewName.".store"));
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        $menus = Menu::all();
        $data = [
            'roles' => $role,
            'user' => Auth::user(),
            'title' => $this->title,
            'route' => $this->routeName,
            'induk_opd' => $induk_opd_arr,
            'route' => $this->viewName,
            'unit_kerja' => UnitKerja::pluck('nama', 'id'),
            'menus' => $menus,
        ];
        // dd(Auth::user()->pelanggan);

        return view($this->viewName.'.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        DB::beginTransaction();
        try{

            $role = Role::find($request->role_id);
    
            $request['password'] = Hash::make($request->password);
            $request['level_id'] = $role->id;
            // $request['no_pelanggan'] = Carbon::now()->format('Ymdhis');
            $user = User::create($request->all());
            if(Auth::user()->roles->first()->name == "Admin"){
                $user->assignRole($role->name);
            } else {
                $user->assignRole("Pihak Wajib Pajak");
            }
            foreach($request->menu_access as $menu){
                MenuPermission::create([
                    'user_id' => $user->id,
                    'menu_id' => $menu
                ]);
            }
            
            DB::commit();
            // Log::create([
            //     'pengguna' => Auth::user()->nama,
            //     'kegiatan' => "Buat Data User Dengan Nama ".$request->name,
            // ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data User : '.$user->name]);
        } catch (Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with(['error'=>'Gagal Menambah Data User : '.$e->getMessage()])->withInput($request->all());
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
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        $user = User::findOrFail($id);
        $menu_permission = MenuPermission::where('user_id', $id)->get();
        $menus = Menu::all();
        $kategori_opd_arr = [1=>"Inspektorat", 2=>"Kepala", 3=>"Test"];
        $data=[
            'title' => $this->title,
            'user' => $user,
            'menu_permission' => $menu_permission,
            'menus' => $menus,
            'roles' =>  Role::where('name', '<>', 'Pihak Wajib Pajak')->where('name', '<>', 'pelanggan')->pluck('name','id'),
            'route' => $this->routeName,
            'induk_opd' => $induk_opd_arr,
            'kategori'=> $kategori_opd_arr,
            'unit_kerja' => UnitKerja::pluck('nama', 'id'),
        ];
        // dd(User::findOrFail($id)->pelanggan);
        return view($this->viewName.'.edit')->with($data);
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
        $rules = [];
        $role;
        DB::beginTransaction();
        try{

            if (Auth::user()->roles->first()->name =='Admin') {
                $role = Role::findOrFail($request->role_id);
            } else {
                $role = Role::findOrFail("2");
            }
            $user = User::find($id);
            $menu_permission = MenuPermission::where('user_id', $user->id)->get();
            foreach($menu_permission as $permission){
               if(in_array($permission->menu_id, $request->menu_access)){
                continue;
               } else {
                $permission->delete();
               }
            }
            foreach($request->menu_access as $menu){
                if($menu_permission->contains('menu_id', $menu)){
                    continue;
                } else {
                    MenuPermission::create([
                        'menu_id' => $menu,
                        'user_id' => $user->id,
                    ]);
                }
            }

            $request['password'] = isset($request->password)?\Hash::make($request->password):$user->password;
            $request['level_id'] = $role->id;
            $user->update($request->all());
            $user->syncRoles($role->name);
            DB::commit();
            if (Auth::user()->roles->first()->name =='Admin') {
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data User : '.$user->name]);
            } else {
                return redirect(route('pelanggan.index'))->with(['success'=>'Berhasil Mengubah Data User : '.$user->name]);
            }
        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data User : '.$e->getMessage()])->withErrors($request->all())->withInput($request->all());
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
        DB::beginTransaction();
        try{
            $user = User::findOrFail($id);
            // if ($user->id == Auth::user()->id) {
            //     return redirect()->back()->with(['error'=>'anda tidak dapat menghapus diri sendiri']);
            // }
            // $user->roles()->detach();
            // isset($user->pelanggan)?$user->pelanggan()->delete():'-';
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Data User dengan nama ".$user->name,
            ]);
            $user->delete();
            // $user->pelanggan()->tagihan()->delete();
            // $user->pelanggan()->delete();
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data User : '.$user->name]);
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data User : '.$e->getMessage()]);
        }
    }
    
    public function logout(Request $request)
    {
        // Log::create([
        //     'pengguna' => Auth::user()->nama,
        //     'kegiatan' => "Logout"
        // ]);
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
