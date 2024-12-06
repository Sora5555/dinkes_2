<?php

namespace App\Http\Controllers;

use App\Models\Bidan;
use DB,Session;
use App\Models\Log;
use App\Models\NPA;
use App\Models\Jabatan;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use App\Models\UptDaerah;
use App\Models\KategoriNPA;
use App\Models\JenisJabatan;
use App\Models\Perawat;
use Illuminate\Http\Request;
use App\Models\UnitOrganisasi;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    protected $routeName = 'jabatan';
    protected $viewName = 'jabatan';
    protected $title = 'Jabatan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return NPA::whereHas('kategori',function($query){
        //     $query->where('kategori','Industri Besar');
        // })->get();

        $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::all();
        }

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' =>  $unit_kerja,
            // 'jabatan' => Jabatan::get(),
            // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
            // 'unit_organisasi' => UnitOrganisasi::get()
        ];
        // $model = Jabatan::where('induk_opd_id',1)->get();

        // $modelArr = [];

        // $nameArrCheck = [];

        // $idArrCheck = [];

        // foreach ($model as $key => $value) {
        //     if($value->descendants()->count() > 0){
        //         $variable = $value->descendantsAndSelf()->get();
        //         foreach ($variable as $key => $value1) {
        //             # code...
        //             if(!in_array($value1->id, $nameArrCheck)){
        //                     array_push($nameArrCheck, $value1->id);
        //                     array_push($modelArr, $value1);
        //                 }
        //         }
        //     } else {
        //         if($value->descendants()->count() == 0 && !in_array($value->id, $nameArrCheck)){
        //             array_push($modelArr, $value);
        //             array_push($nameArrCheck, $value->id);
        //         }
        //     }
        // }
        // $modelArr = collect((object) $modelArr);
        // dd($modelArr->sortBy('path'));

        return view($this->viewName.'.index')->with($data);
    }

    public function datatable(Request $request){
        $model = Jabatan::where('induk_opd_id', $request->induk_opd)->get();

        $modelArr = [];

        $nameArrCheck = [];

        $idArrCheck = [];

        foreach ($model as $key => $value) {
            if($value->descendants()->count() > 0){
                $variable = $value->descendantsAndSelf()->get();
                foreach ($variable as $key => $value1) {
                    # code...
                    if(!in_array($value1->id, $nameArrCheck)){
                            array_push($nameArrCheck, $value1->id);
                            array_push($modelArr, $value1);
                        }
                }
            } else {
                if($value->descendants()->count() == 0 && !in_array($value->id, $nameArrCheck)){
                    array_push($modelArr, $value);
                    array_push($nameArrCheck, $value->id);
                }
            }
        }
        $modelArr = collect((object) $modelArr);
        $modelArr = $modelArr->sortBy('path');
        $datatables = DataTables::of($modelArr)
        ->addColumn('nama', function($modelArr){
            $char = $modelArr->level * $modelArr->level * 4;
            $charRes = $char . 'px';
           return "<span style='padding-left:$charRes'>$modelArr->nama</span>";
        })
        ->addColumn('unit_organisasi',function($model){
            if($model->unitOrganisasi){
                return $model->UnitOrganisasi->nama;
            } else {
                return "";
            }
        })->addColumn('jenis_jabatan', function($model){
            if($model->jenisJabatan){
                return $model->jenisJabatan->nama;
            } else{
                return "";
            }
        })
        ->addColumn('action', function($model){
            $route = 'jabatan';
            $data = $model;
            return view('layouts.includes.table-action-jabatan',compact('data','route'));
        })
        ->rawColumns(['nama']);
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'kategori'=>KategoriNPA::pluck('kategori','id'),
            'wilayah'=>UptDaerah::pluck('nama_daerah','id'),
        ];

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
        try {
            $level = null;

            if($request->induk_jabatan_id == 0){
                $level = 0;
            } else {
                $level = Jabatan::where('id', $request->induk_jabatan_id)->first()->level + 1;
            }


            $npa = Jabatan::create([
                'nama' => $request->nama,
                'level' => $level,
                'bezetting' => $request->bezetting,
                'jenis_jabatan_id' => $request->jenis_jabatan_id,
                'induk_opd_id' => $request->induk_opd_id,
                'unit_organisasi_id' => $request->unit_organisasi_id,
                'induk_jabatan_id' => $request->induk_jabatan_id,
            ]);
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Data Jabatan"
            ]);
            DB::commit();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Jabatan']);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
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
        // return NPA::findOrFail($id)->wilayah->pluck('id');
        $data=[
            'npa'=>NPA::findOrFail($id),
            'route'=>$this->routeName,
            'title'=>$this->title,
            'kategori'=>KategoriNPA::pluck('kategori','id'),
            'wilayah'=>UptDaerah::pluck('nama_daerah','id'),
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
        $rules = [];
        $unitKerja = UnitKerja::where('id', $id)->first();

        try {
            $perawat = Perawat::where('unit_kerja_id', $id)->first();
            $bidan = Bidan::where('unit_kerja_id', $id)->first();

            $perawat->update([
                'laki_laki' => $request->perawat_laki_laki,
                'perempuan' => $request->perawat_perempuan,
            ]);
            $bidan->update([
                'perempuan' => $request->bidan,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah data']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
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
        try {
            $jabatan = Jabatan::findOrFail($id);
            if(count($jabatan->descendants) > 0){
                return redirect(route($this->routeName.'.index'))->with(['error'=>'Data Memiliki Anak Data']);    
            } else{
                $jabatan->delete();
            }
            DB::commit();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Jabatan']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Jabatan : '.$e->getMessage()]);
        }
    }
    public function api($id){

        $unitOrganisasi = UnitOrganisasi::where('induk_opd_id', $id)->get();

        $modelArr = [];

        $nameArrCheck = [];

        $idArrCheck = [];
        $model = Jabatan::where('induk_opd_id', $id)->get();

        foreach ($model as $key => $value) {
            if($value->descendants()->count() > 0){
                $variable = $value->descendantsAndSelf()->orderBy('path')->get();
                foreach ($variable as $key => $value1) {
                    # code...
                    if(!in_array($value1->id, $nameArrCheck)){
                            array_push($nameArrCheck, $value1->id);
                            array_push($modelArr, $value1);
                        }
                }
            } else {
                if($value->descendants()->count() == 0 && !in_array($value->id, $nameArrCheck)){
                    array_push($modelArr, $value);
                    array_push($nameArrCheck, $value->id);
                }
            }
        }
        $modelArr = collect((object) $modelArr);
        $modelArr = $modelArr->toArray();
        $jenisJabatan = JenisJabatan::all();
        
        if(count($unitOrganisasi) > 0){
            return response()->json([
                'status' => 'success',
                'data' => $unitOrganisasi,
                'dataModel' => $modelArr,
                'jenisJabatan' => $jenisJabatan
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'data' => "Kesalahan terjadi saat mengambil data unit organisasi"
            ]);
        }
    }
    public function apiEdit($id){
        $unitKerja = UnitKerja::where('id', $id)->first();
        $tenagaKeperawatan = Perawat::where('unit_kerja_id', $id)->first();
        $bidan = Bidan::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'perawat' => $tenagaKeperawatan,
            'bidan' => $bidan,
        ]);
    }
}