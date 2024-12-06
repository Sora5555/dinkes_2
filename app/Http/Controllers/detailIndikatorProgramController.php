<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorProgram;
use Illuminate\Http\Request;

class detailIndikatorProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $detailIndikatorProgram = detailIndikatorProgram::where('id', $id)->first();
        try {
            //code...
            $detailIndikatorProgram->update([
                'target_indikator' => $request->target_indikator,
                'kondisi_awal' => $request->kondisi_awal,
            ]);

            return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Edit data Target']);
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
    }

    public function apiEdit($id){
        $indikatorProgram = detailIndikatorProgram::where('id', $id)->first();
            return response()->json([
                'status' => 'success',
                'data' => $indikatorProgram,
                
            ]);
        }
}
