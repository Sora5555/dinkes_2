<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\Kegiatan;
use App\Models\UnitKerja;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\detailSubKegiatan;
use App\Models\Posyandu;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SubKegiatanController extends Controller
{
    protected $routeName = 'sub_kegiatan';
    protected $viewName = 'sub_kegiatan';
    protected $title = 'Sub Kegiatan';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $induk_opd_arr = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::all();
        }
        return view('sub_kegiatan.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));
    }

    public function datatable(Request $request){
        $datas = SubKegiatan::where('kegiatan_id', $request->kegiatan_id)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'sub_kegiatan';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaran_sub_kegiatan';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikator_sub_kegiatan';
            return view('layouts.includes.program-indikator',compact('data','route'));
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
        try {
            $subKegiatan = SubKegiatan::create([
                'kode' => $request->kode,
                'kegiatan_id' => $request->kegiatan_id,
                'uraian' => $request->uraian,
                'induk_opd_id' => $request->induk_opd_id,
            ]);

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
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
        //
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
        try {
           $unitKerja = UnitKerja::where("id", $id)->first();
           $posyandu = Posyandu::where('unit_kerja_id', $id)->first();
           $posyandu->update([
            'pratama' => $request->pratama,
            'madya' => $request->madya,
            'purnama' => $request->purnama,
            'mandiri' => $request->mandiri,
            'aktif' => $request->aktif,
            'posbindu' => $request->posbindu,
           ]);
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data']);
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
        //
        try {
            $detailSubKegiatan = detailSubKegiatan::where("sub_kegiatan_id", $id)->first();
            $subKegiatan = SubKegiatan::find($id);
            if($detailSubKegiatan){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Sub Kegiatan Masih Memiliki data Rincian']);
            }
            $subKegiatan->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menghapus Data Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiKegiatan($id){

        $kegiatan = Kegiatan::where('program_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $kegiatan,
        ]);
    }

    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
        $posyandu = Posyandu::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'posyandu' => $posyandu,
        ]);
    }
}
