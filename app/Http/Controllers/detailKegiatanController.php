<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorKegiatan;
use App\Models\Jabatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\detailKegiatan;
use App\Models\IndikatorKegiatan;
use App\Models\SasaranKegiatan;

class detailKegiatanController extends Controller
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
            $kegiatan = Kegiatan::where('id', $request->kegiatan_id)->first();
            $jabatan = Jabatan::where('id', $request->jabatan_id)->first();
            $detailKegiatan = detailKegiatan::create([
                'detail_program_id' => $request->detail_program_id,
                'kegiatan_id' => $request->kegiatan_id,
                'nama_kegiatan' => $kegiatan->uraian,
                'jabatan_id' => $request->jabatan_id,
                'nama_jabatan' => $jabatan->nama,
            ]);
            if($request->sasaran_kegiatan_id){
                foreach ($request->sasaran_kegiatan_id as $key => $value) {
                    # code...
                    $sasaranKegiatan = SasaranKegiatan::where('id', $value)->first();
                    $indikatorKegiatan = IndikatorKegiatan::where('id', $request->indikator_kegiatan_id[$key])->first();
                    $detailIndikatorProgram = detailIndikatorKegiatan::create([
                        'detail_kegiatan_id' => $detailKegiatan->id,
                        'sasaran_kegiatan_id' => $value,
                        'nama_sasaran_kegiatan' => $sasaranKegiatan->nama,
                        'indikator_kegiatan_id' => $request->indikator_kegiatan_id[$key],
                        'nama_indikator_kegiatan' => $indikatorKegiatan->nama,
                        'target_indikator' => $request->target[$key],
                        'kondisi_awal' => $request->kondisi[$key],
                    ]);
                }
            }
            return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menambah Data Kegiatan']);
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
        $detailKegiatan = detailKegiatan::where('id', $id)->first();
        $detailSubKegiatan = $detailKegiatan->detailSubKegiatan;
        if(count($detailSubKegiatan) > 0){
            return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Masih Memiliki Data Sub Kegiatan']);    
        }
        if(count($detailKegiatan->detailIndikatorKegiatan) > 0){
            foreach ($detailKegiatan->detailIndikatorKegiatan as $key => $value) {
                $value->delete();
            }
        }
        $detailKegiatan->delete();

        return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menghapus Data Kegiatan']);
    }
}
