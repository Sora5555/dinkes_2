<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorProgram;
use App\Models\IndikatorProgram;
use Illuminate\Http\Request;

class IndikatorProgramController extends Controller
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
       try {
        $detailIndikatorProgram = detailIndikatorProgram::where('sasaran_program_id', $request->sasaran_program_id)->first();
        $query = IndikatorProgram::create($request->all());
        if($detailIndikatorProgram){
            $detailIndikatorProgram->update([
                'indikator_program_id' => $query->id,
                'nama_indikator_program' => $request->nama,
            ]);
        }

        return redirect(route('program.index'))->with(['success'=>'Berhasil Menambah data indikator Program']);
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
        $indikatorProgram = IndikatorProgram::find($id);
        $detailIndikatorProgram = detailIndikatorProgram::where('indikator_program_id', $id)->first();

        try {
            $indikatorProgram->update([
                'nama' => $request->nama
            ]);
            if($detailIndikatorProgram){
                $detailIndikatorProgram->update([
                    'nama_indikator_program' => $request->nama,
                ]);
            }

            return redirect(route('program.index'))->with(['success'=>'Berhasil Mengubah data indikator Program']);
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
        $indikatorProgram = IndikatorProgram::find($id);
        $detailIndikatorProgram = detailIndikatorProgram::where('indikator_program_id', $id)->first();

        try {
            if($detailIndikatorProgram){
                $detailIndikatorProgram->update([
                    'indikator_program_id' => null,
                    'nama_indikator_program' => null,
                ]);
            }
            $indikatorProgram->delete();

            return redirect(route('program.index'))->with(['success'=>'Berhasil Menghapus data indikator Program']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $indikatorProgram = IndikatorProgram::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $indikatorProgram,
        ]);
    }
}
