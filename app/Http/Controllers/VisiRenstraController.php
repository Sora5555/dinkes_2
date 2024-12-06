<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\MisiRpjmd;
use App\Models\visiRpjmd;
use App\Models\MisiRenstra;
use App\Models\SubKegiatan;
use App\Models\TujuanRpjmd;
use App\Models\VisiRenstra;
use App\Models\IndikatorOpd;
use App\Models\SasaranRpjmd;
use Illuminate\Http\Request;
use App\Models\detailProgram;
use App\Models\TujuanRenstra;
use App\Models\detailKegiatan;
use App\Models\SasaranRenstra;
use App\Models\detailSubKegiatan;
use App\Models\IndikatorPemerintah;
use Illuminate\Support\Facades\Auth;
use App\Models\detailIndikatorProgram;
use App\Models\detailIndikatorKegiatan;
use App\Models\DetailIndikatorSubKegiatan;

class VisiRenstraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'visi_renstra';
    protected $viewName = 'visi_renstra';
    protected $title = 'Visi dan Misi Renstra';

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
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'visi' => visiRpjmd::all(),
        ];
        return view($this->viewName.'.index')->with($data);
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
        $IndukOpd = IndukOpd::where('id', $request->induk_opd_id);
        try {
            $visiRenstra = VisiRenstra::create([
                'nama' => $request->nama_visi,
                'induk_opd_id' => $request->induk_opd_id,
            ]);
            $IndukOpd->update([
                'status' => 2,
            ]);

            foreach ($request->nama as $key => $value) {
                # code...
                $misiRenstra = MisiRenstra::create([
                    'nama' => $value,
                    'visi_renstra_id' => $visiRenstra->id,
                ]);
            }

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menambah data visi dan Misi Renstra']);

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
        $misiRenstra = MisiRenstra::where('id', $id)->first();
        try {
            //code...
            $misiRenstra->update([
                'nama' => $request->nama,
            ]);

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Misi Renstra: '.$misiRenstra->nama]);
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
        $misiRenstra = MisiRenstra::where('id', $id)->first();
        try {
            $misiRenstra->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menghapus Data Misi Renstra: '.$misiRenstra->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $IndukOpd = IndukOpd::where('id', $id)->first();
        $sasaranRenstra = SasaranRenstra::all();
        if($IndukOpd->status == 2){
            $renstra = $IndukOpd->Renstra->first();
            $misi = $renstra->Misi;
            return response()->json([
                'status' => 'success',
                'data' => $IndukOpd,
                'renstra' => $renstra,
                'misi' => $misi,
                'tujuan' => TujuanRenstra::all(),
                'indikatorOpd' => IndikatorOpd::all(),
                'sasaranRenstra' => $sasaranRenstra,
                'detailProgram' => detailProgram::all(),
                'detailIndikatorProgram' => detailIndikatorProgram::all(),
                'detailKegiatan' => detailKegiatan::all(),
                'detailIndikatorKegiatan' => detailIndikatorKegiatan::all(),
                'detailSubKegiatan' => detailSubKegiatan::all(),
                'detailIndikatorSubKegiatan' => DetailIndikatorSubKegiatan::all(),
                'subKegiatan' => SubKegiatan::all(),
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $IndukOpd,
                'visi' => visiRpjmd::all(),
                'misi' => MisiRpjmd::all(),
                'tujuan' => TujuanRpjmd::all(),
                'sasaran' => SasaranRpjmd::all(),
                'tujuanRenstra' => TujuanRenstra::all(),
                'Iku' => IndikatorPemerintah::all(),
                'indikatorOpd' => IndikatorOpd::all(),
                'sasaranRenstra' => $sasaranRenstra,
                'detailProgram' => detailProgram::all(),
                'detailIndikatorProgram' => detailIndikatorProgram::all(),
                'detailKegiatan' => detailKegiatan::all(),
                'detailIndikatorKegiatan' => detailIndikatorKegiatan::all(),
                'detailSubKegiatan' => detailSubKegiatan::all(),
                'detailIndikatorSubKegiatan' => DetailIndikatorSubKegiatan::all(),
                'subKegiatan' => SubKegiatan::all(),
            ]);
        }

    }
    public function apiEditMisi($id){
        $misiRenstra = MisiRenstra::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $misiRenstra,
        ]);

    }
    public function apiEditRpjmd($id){
        $indukOpd = IndukOpd::where('id', $id)->first();

        try {
            //code...
            $indukOpd->update([
                'status' => 1
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $indukOpd,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'failure',
                'data' => $th->getMessage(),
            ]);
        }


    }
    public function apiEditNonRpjmd($id){
        $indukOpd = IndukOpd::where('id', $id)->first();

        try {
            //code...
            $indukOpd->update([
                'status' => 0
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $indukOpd,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'failure',
                'data' => $th->getMessage(),
            ]);
        }


    }
}
