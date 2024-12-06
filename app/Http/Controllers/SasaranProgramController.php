<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorProgram;
use App\Models\detailProgram;
use App\Models\SasaranProgram;
use Illuminate\Http\Request;

class SasaranProgramController extends Controller
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
            $detailProgram = detailProgram::where('program_id', $request->program_id)->first();
            $query = SasaranProgram::create($request->all());
            if($detailProgram){
                $detailIndikatorProgram = detailIndikatorProgram::create([
                    'detail_program_id' => $detailProgram->id,
                    'sasaran_program_id' => $query->id,
                    'nama_sasaran_program' => $request->nama,
                ]);
            }


            return redirect(route('program.index'))->with(['success'=>'Berhasil Menambah data sasaran Program']);
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
        $sasaranProgram = SasaranProgram::find($id);
        $detailIndikatorProgram = detailIndikatorProgram::where('sasaran_program_id', $id);
        try {
            $sasaranProgram->update([
                'nama' => $request->nama
            ]);
            if($detailIndikatorProgram){
                $detailIndikatorProgram->update([
                    'nama_sasaran_program' => $request->nama,
                ]);
    
            }
            return redirect(route('program.index'))->with(['success'=>'Berhasil Mengubah data sasaran Program']);
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
        $sasaranProgram = SasaranProgram::find($id);
        $detailIndikatorProgram = detailIndikatorProgram::where('sasaran_program_id', $id)->first();



        try {
            if($detailIndikatorProgram){
                $detailIndikatorProgram->delete();
            }
            $sasaranProgram->delete();
            return redirect(route('program.index'))->with(['success'=>'Berhasil Menghapus data Sasaran Program']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $sasaranProgram = SasaranProgram::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $sasaranProgram,
        ]);
    }
}
