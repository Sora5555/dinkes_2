<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\IndukOpd;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\detailKegiatan;
use App\Models\Manajemen;
use App\Models\PejabatStruktural;
use App\Models\TenagaPendidik;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'kegiatan';
    protected $viewName = 'kegiatan';
    protected $title = 'Kegiatan';

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
        return view('kegiatan.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));
    }

    public function datatable(Request $request){
        $datas = Kegiatan::where('program_id', $request->program_id)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'kegiatan';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaranKegiatan';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikatorKegiatan';
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
            $Kegiatan = Kegiatan::create($request->all());

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Kegiatan : '.$Kegiatan->id]);
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
    //    dd($request->all());
       $unitKerja = UnitKerja::where('id', $id)->first();
       $pejabatStruktural = PejabatStruktural::where('unit_kerja_id', $id)->first();
       $tenagaPendidik = TenagaPendidik::where('unit_kerja_id', $id)->first();
       $pendukungManajemen = Manajemen::where('unit_kerja_id', $id)->first();
        try {
            $pejabatStruktural->update([
                'laki_laki' => $request->pejabatStrukturalLakiLaki,
                'perempuan' => $request->pejabatStrukturalPerempuan,
            ]);
            $tenagaPendidik->update([
                'laki_laki' => $request->tenagaPendidikLakiLaki,
                'perempuan' => $request->tenagaPendidikPerempuan,
            ]);
            $pendukungManajemen->update([
                'laki_laki' => $request->pendukungManajemenLakiLaki,
                'perempuan' => $request->pendukungManajemenPerempuan,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil mengubah Data']);
            //code...
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
        $kegiatan = Kegiatan::find($id);
        $detailKegiatan = detailKegiatan::where('kegiatan_id', $id)->first();

        try {
            if($detailKegiatan){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Kegiatan Masih Memiliki data rincian']);
            }
            $kegiatan->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil menghapus Data Kegiatan : '.$kegiatan->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiProgram($id){

        $program = Program::where('induk_opd_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $program,
        ]);
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
        $pejabatStruktural = PejabatStruktural::where('unit_kerja_id', $id)->first();
        $tenagaPendidik = TenagaPendidik::where('unit_kerja_id', $id)->first();
        $pendukungManajemen = Manajemen::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'pejabatStruktural' => $pejabatStruktural,
            'tenagaPendidik' => $tenagaPendidik,
            'pendukungManajemen' => $pendukungManajemen,
        ]);
    }
}
