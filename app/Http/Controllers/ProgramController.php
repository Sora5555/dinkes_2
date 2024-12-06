<?php

namespace App\Http\Controllers;

use App\Models\Apoteker;
use App\Models\Program;
use App\Models\IndukOpd;
use App\Models\hariLibur;
use Illuminate\Http\Request;
use App\Models\detailProgram;
use App\Models\TenagaTeknisFarmasi;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Contracts\DataTable;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'program';
    protected $viewName = 'program';
    protected $title = 'Program';

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
        return view('program.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));

    }

    public function datatable(Request $request){
        $datas = Program::where('induk_opd_id', $request->induk_opd)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'program';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaranProgram';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikatorProgram';
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
        $route = $this->routeName;
        $title = $this->title;
        return view('hari_libur.create', compact('title', 'route'));
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
            $query = Program::create($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Program : '.$query->id]);
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
        $data = HariLibur::where('id', $id)->first();
        $route = $this->routeName;
        $title = $this->title;
        return view('hari_libur.edit', compact('title', 'route', 'data'));

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

        $unitKerja = UnitKerja::where('id', $id)->first();
        try {
            $teknisFarmasi = TenagaTeknisFarmasi::where('unit_kerja_id', $id)->first();
            $apoteker = Apoteker::where('unit_kerja_id', $id)->first();
            $teknisFarmasi->update([
                'laki_laki' => $request->teknisFarmasiLakiLaki,
                'perempuan' => $request->teknisFarmasiPerempuan,
            ]);
            $apoteker->update([
                'laki_laki' => $request->apotekerLakiLaki,
                'perempuan' => $request->apotekerPerempuan
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil mengubah Data Program']);
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
            $query = Program::find($id);
            $detailProgram = detailProgram::where('program_id', $id)->first();

            if($detailProgram){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Program Masih Memiliki data rincian']);    
            }
            $query->delete();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil menghapus Data Program']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function apiEdit($id){

       $unitKerja = UnitKerja::where('id', $id)->first();

       $teknisFarmasi = TenagaTeknisFarmasi::where('unit_kerja_id', $id)->first();
       $apoteker = Apoteker::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'teknisFarmasi' => $teknisFarmasi,
            'apoteker' => $apoteker,
        ]);
    }
}
