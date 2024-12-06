<?php

namespace App\Http\Controllers;

use Session,DB;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Eselon;
use App\Models\IndukOpd;
use App\Models\KategoriNPA;
use App\Models\TenagaGizi;
use App\Models\TenagaKesehatanLingkungan;
use App\Models\TenagaKesehatanMasyarakat;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\UnitOrganisasi;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UnitOrganisasiController extends Controller
{
    protected $routeName = 'unit_organisasi';
    protected $viewName = 'unit_organisasi';
    protected $title = 'Unit Organisasi';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::all();
        }
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' => $unit_kerja,
            // 'eselon_arr' =>Eselon::pluck('nama', 'id')
        ];
        return view($this->routeName.'.index')->with($data);
    }

    public function datatable(Request $request){

        $datas = UnitOrganisasi::where('induk_opd_id', $request->induk_opd)->get();

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('eselon',function($data){
                return $data->eselon->nama;
            })
            ->addColumn('action', function ($data) {
                $route = 'unit_organisasi';
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
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
        ];
        return view($this->routeName.'.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'kategori'=>'required',
        // ],[
        //     'kategori.required'=>'kategori tidak boleh kosong',
        // ]);
        DB::beginTransaction();
        try {
            UnitOrganisasi::create($request->all());
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Data Unit Organisasi"
            ]);
            DB::commit();
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Unit Organisasi: '.$request->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menambah data Unit Organisasi : '.$e->getMessage()])->withErrors($request->nama)->withInput($request->all());
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
        $data=[
            'UnitOrganisasi'=>UnitOrganisasi::findOrFail($id),
            'route'=>$this->routeName,
            'title'=>$this->title,
            'eselon_arr' => Eselon::pluck('nama', 'id'),
        ];
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

        // dd($request->all());
        DB::beginTransaction();
        try {
            $unitKerja = UnitKerja::where('id', $id)->first();
            $kesehatanMasyarakat = TenagaKesehatanMasyarakat::where('unit_kerja_id', $id)->first();
            $tenagaGizi = TenagaGizi::where('unit_kerja_id', $id)->first();
            $kesehatanLingkungan = TenagaKesehatanLingkungan::where('unit_kerja_id', $id)->first();
            $kesehatanMasyarakat->update([
                'laki_laki' => $request->kesehatanMasyarakatLakiLaki,
                'perempuan' => $request->kesehatanMasyarakatPerempuan,
            ]);
            $tenagaGizi->update([
                'laki_laki' => $request->tenagaGiziLakiLaki,
                'perempuan' => $request->tenagaGiziPerempuan,
            ]);
            $kesehatanLingkungan->update([
                'laki_laki' => $request->kesehatanLingkunganLakiLaki,
                'perempuan' => $request->kesehatanLingkunganPerempuan,
            ]);
            DB::commit();
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil mengubah Data Unit Organisasi: '.$request->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal mengubah Data Unit Organisasi : '.$e->getMessage()])->withErrors($request->nama)->withInput($request->all());
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
        try {
            $kategori = UnitOrganisasi::findOrFail($id);
            $kategori->delete();
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Data Unit Organisasi"
            ]);
            return redirect()->back()->with(['success'=>'Berhasil menghapus Data Unit Organisasi : '.$kategori->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal menghapus Data Unit Organisasi : '.$e->getMessage()])->withErrors($kategori->kategori);
        }
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
 
        $kesehatanMasyarakat = TenagaKesehatanMasyarakat::where('unit_kerja_id', $id)->first();
        $tenagaGizi = TenagaGizi::where('unit_kerja_id', $id)->first();
        $kesehatanLingkungan = TenagaKesehatanLingkungan::where('unit_kerja_id', $id)->first();
 
         return response()->json([
             'status' => 'success',
             'data' => $unitKerja,
             'kesehatanMasyarakat' => $kesehatanMasyarakat,
             'tenagaGizi' => $tenagaGizi,
             'kesehatanLingkungan' => $kesehatanLingkungan,
         ]);
     }
}
