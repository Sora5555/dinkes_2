<?php

namespace App\Http\Controllers;

use App\Models\AhliLabMedik;
use App\Models\kategoriOpd;
use App\Models\KeteknisanMedik;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Role;
use App\Models\TenagaTeknikBiomedik;
use App\Models\TerapiFisik;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\UptDaerah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class KategoriOpdController extends Controller
{
    protected $routeName = 'kategori_opd';
    protected $viewName = 'kategori_opd';
    protected $title = 'Kategori OPD';

    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::all();
        }
        return view($this->viewName.'.index',compact('route','title', 'unit_kerja'));
    }

    public function datatable()
    {
        $datas = kategoriOpd::get();

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) {
                $route = 'kategori_opd';
                return view('layouts.includes.table-action',compact('data','route'));
            });

        return $datatables->make(true);
    }

    public function create(Request $request)
    {
        $route = $this->routeName;
        $title = $this->title;
        
        return view($this->viewName.'.create',compact('route','title'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        try{

            // $role = Role::where('nama_role','UPT. Daerah')->first();

            $query1 = kategoriOpd::create($request->all());

            // $query = User::create([
            //     'name' => $request->nama_daerah,
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            //     'upt_daerah_id' => $query1->id,
            //     'role_id' => $role->id
            // ]);

            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Kategori OPD"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Kategori OPD : '.$query1->nama]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Upt Daerah : '.$e->getMessage()])->withErrors($request->all())->withInput($request->all());
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = [
            'kategori_opd'=>kategoriOpd::findOrFail($id),
            'title'=>$this->title,
            'route'=>$this->routeName,
        ];
        return view($this->viewName.'.edit')->with($data);
    }

    public function update(Request $request, $id)
    {

        $unitKerja = UnitKerja::where('id', $id)->first();

        $teknisBiomedika = TenagaTeknikBiomedik::where('unit_kerja_id', $id)->first();
        $terapiFisik = TerapiFisik::where('unit_kerja_id', $id)->first();
        $labMedik = AhliLabMedik::where('unit_kerja_id', $id)->first();
        $keteknisanMedik = KeteknisanMedik::where("unit_kerja_id", $id)->first();


        try{  

            $teknisBiomedika->update([
                'laki_laki' => $request->teknisBiomedikaLakiLaki,
                'perempuan' => $request->teknisBiomedikaPerempuan,
            ]);
            $labMedik->update([
                'laki_laki' => $request->labMedikLakiLaki,
                'perempuan' => $request->labMedikPerempuan,
            ]);
            $terapiFisik->update([
                'laki_laki' => $request->terapiFisikLakiLaki,
                'perempuan' => $request->terapiFisikPerempuan,
            ]);
            $keteknisanMedik->update([
                'laki_laki' => $request->keteknisanMedikLakiLaki,
                'perempuan' => $request->keteknisanMedikPerempuan,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Kategori OPD : '.$request->nama]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Kategori OPD : '.$e->getMessage()])->withErrors($request->all())->withInput($request->all());
        }
    }
    
    public function destroy(Request $request,$id)
    {
        try {
            $kategori_opd = kategoriOpd::findOrFail($id);
            $kategori_opd->delete();
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Kategori OPD"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Kategori OPD : '.$kategori_opd->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Kategori OPD : '.$e->getMessage()])->withErrors($request->all());
        }
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
 
        $teknisBiomedika = TenagaTeknikBiomedik::where('unit_kerja_id', $id)->first();
        $terapiFisik = TerapiFisik::where('unit_kerja_id', $id)->first();
        $labMedik = AhliLabMedik::where('unit_kerja_id', $id)->first();
        $keteknisanMedik = KeteknisanMedik::where('unit_kerja_id', $id)->first();
 
         return response()->json([
             'status' => 'success',
             'data' => $unitKerja,
             'teknisBiomedika' => $teknisBiomedika,
             'terapiFisik' => $terapiFisik,
             'labMedik' => $labMedik,
             'keteknisanMedik' => $keteknisanMedik,
         ]);
     }
}
