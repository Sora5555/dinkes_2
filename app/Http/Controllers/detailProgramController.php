<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorProgram;
use App\Models\Jabatan;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Models\detailProgram;
use App\Models\IndikatorProgram;
use App\Models\SasaranProgram;

class detailProgramController extends Controller
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
        $program = Program::where('id', $request->program_id)->first();
        $jabatan = Jabatan::where('id', $request->jabatan_id)->first();
        $detailProgram = detailProgram::create([
            'indikator_pemerintah_id' => $request->indikator_pemerintah_id,
            'indikator_opd_id' => $request->indikator_opd_id,
            'program_id' => $request->program_id,
            'nama_program' => $program->uraian,
            'jabatan_id' => $request->jabatan_id,
            'nama_jabatan' => $jabatan->nama,
        ]);
        if($request->sasaran_program_id){
            foreach ($request->sasaran_program_id as $key => $value) {
                # code...
                $sasaranProgram = SasaranProgram::where('id', $value)->first();
                $indikatorProgram = IndikatorProgram::where('id', $request->indikator_program_id[$key])->first();
                $detailIndikatorProgram = detailIndikatorProgram::create([
                    'detail_program_id' => $detailProgram->id,
                    'sasaran_program_id' => $value,
                    'nama_sasaran_program' => $sasaranProgram->nama,
                    'indikator_program_id' => $request->indikator_program_id[$key],
                    'nama_indikator_program' => $indikatorProgram->nama,
                    'target_indikator' => $request->target[$key],
                    'kondisi_awal' => $request->kondisi[$key],
                ]);
            }
        }
        return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menambah Data Program']);
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
        $detailProgram = detailProgram::where('id', $id)->first();

        try {
            //code...
            $detailKegiatan = $detailProgram->detailKegiatan;
            if(count($detailKegiatan) > 0){
                return redirect()->route('program_dan_kegiatan.index')->with(['error'=>'Masih memiliki data kegiatan']);
            }
            $detailIndikatorProgram = $detailProgram->detailIndikatorProgram;

            if(count($detailIndikatorProgram) > 1){
                foreach ($detailIndikatorProgram as $key => $value) {
                    # code...
                    $value->delete();
                }
            }
            $detailProgram->delete();

            return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menghapus Data Program']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
