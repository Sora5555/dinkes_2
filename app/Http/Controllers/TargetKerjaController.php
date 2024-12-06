<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\IndikatorOpd;
use Illuminate\Http\Request;
use App\Models\IndikatorPemerintah;
use Illuminate\Support\Facades\Auth;

class TargetKerjaController extends Controller
{
    protected $routeName = 'target_kerja';
    protected $viewName = 'target_kerja';
    protected $title = 'Target Kerja';

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
        return view('target_kerja.index',compact('route','title', 'induk_opd_arr'));

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
        try {
            if($request->indikator_pemerintah_id){
                $indikator = IndikatorPemerintah::where('id', $id)->first();
                $indikator->update([
                    'target_kerja' => $request->target_kerja
                ]);
            } else{
                $indikator = IndikatorOpd::where('id', $id)->first();
                $indikator->update([
                    'target_kerja' => $request->target_kerja
                ]);
            }

            return redirect(route('target_kerja.index'))->with(['success'=>'Berhasil Menambah data target indikator']);
        } catch (\Throwable $th) {
            //throw $th;
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
    }

    public function apiEdit($id){

        $indikatorPemerintah = IndikatorPemerintah::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $indikatorPemerintah,
        ]);
    }
    public function apiEditOpd($id){

        $indikatorOpd = IndikatorOpd::find($id);
        if(count($indikatorOpd->detailProgram) == 0){
            return response()->json([
                'status' => 'failure',
                'message' => "Silahkan Menambahkan Detail Program Untuk Indikator Opd ini",
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => $indikatorOpd,
        ]);
    }
}
