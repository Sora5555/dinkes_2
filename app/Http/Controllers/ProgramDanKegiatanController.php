<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Program;
use App\Models\IndukOpd;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\IndikatorProgram;
use App\Models\IndikatorKegiatan;
use App\Models\IndikatorSubKegiatan;
use Illuminate\Support\Facades\Auth;

class ProgramDanKegiatanController extends Controller
{
    protected $routeName = 'program_dan_kegiatan';
    protected $viewName = 'program_dan_kegiatan';
    protected $title = 'Program Dan Kegiatan';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $induk_opd_arr = $indukOpd;
        return view('program_dan_kegiatan.index',compact('route','title', 'induk_opd_arr'));

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
    }

    public function apiEdit($id){
        $IndukOpd = IndukOpd::where('id', $id)->first();
        $Program = Program::where('induk_opd_id', $id)->get();
        $Jabatan = Jabatan::where('induk_opd_id', $id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $IndukOpd,
                'program' => $Program,
                'jabatan' => $Jabatan
                
            ]);
        }
    public function apiKegiatan($id){
        $IndukOpd = IndukOpd::where('id', $id)->first();
        $Kegiatan = Kegiatan::where('program_id', $id)->doesntHave('detailKegiatan')->get();
        $program = Program::where('id', $id)->first();
        $Jabatan = Jabatan::where('induk_opd_id', $program->induk_opd_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $IndukOpd,
                'kegiatan' => $Kegiatan,
                'jabatan' => $Jabatan
                
            ]);
        }
    public function apiSubKegiatan($id){
        $IndukOpd = IndukOpd::where('id', $id)->first();
        $SubKegiatan = SubKegiatan::where('kegiatan_id', $id)->doesntHave('detailSubKegiatan')->get();
        $Kegiatan = Kegiatan::where('id', $id)->first();
        $Jabatan = Jabatan::where('induk_opd_id', $Kegiatan->program->induk_opd_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $IndukOpd,
                'sub_kegiatan' => $SubKegiatan,
                'jabatan' => $Jabatan
                
            ]);
        }
    public function apiSasaran($id){
        $Program = Program::where('id', $id)->first();
        $sasaran = $Program->Sasaran;
        $indikatorProgram = IndikatorProgram::all();

            return response()->json([
                'status' => 'success',
                'sasaran' => $sasaran,
                'indikatorProgram' => $indikatorProgram
            ]);
        }
    public function apiSasaranKegiatan($id){
        $Kegiatan = Kegiatan::where('id', $id)->first();
        $sasaran = $Kegiatan->Sasaran;
        $indikatorKegiatan = IndikatorKegiatan::all();

            return response()->json([
                'status' => 'success',
                'sasaran' => $sasaran,
                'indikatorKegiatan' => $indikatorKegiatan
            ]);
        }
    public function apiSasaranSubKegiatan($id){
        $Kegiatan = SubKegiatan::where('id', $id)->first();
        $sasaran = $Kegiatan->Sasaran;
        $indikatorKegiatan = IndikatorSubKegiatan::all();

            return response()->json([
                'status' => 'success',
                'sasaran' => $sasaran,
                'indikatorKegiatan' => $indikatorKegiatan
            ]);
        }
}
