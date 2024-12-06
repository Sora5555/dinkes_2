<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\detailSubKegiatan;
use App\Models\SasaranSubKegiatan;
use App\Models\IndikatorSubKegiatan;
use App\Models\DetailIndikatorSubKegiatan;

class DetailSubKegiatanController extends Controller
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
            $SubKegiatan = SubKegiatan::where('id', $request->sub_kegiatan_id)->first();
            $jabatan = Jabatan::where('id', $request->jabatan_id)->first();
            $detailSubKegiatan = detailSubKegiatan::create([
                'detail_kegiatan_id' => $request->detail_kegiatan_id,
                'sub_kegiatan_id' => $request->sub_kegiatan_id,
                'nama_sub_kegiatan' => $SubKegiatan->uraian,
                'jabatan_id' => $request->jabatan_id,
                'nama_jabatan' => $jabatan->nama,
            ]);
            if($request->sasaran_sub_kegiatan_id){
                foreach ($request->sasaran_sub_kegiatan_id as $key => $value) {
                    # code...
                    $sasaranSubKegiatan = SasaranSubKegiatan::where('id', $value)->first();
                    $indikatorSubKegiatan = IndikatorSubKegiatan::where('id', $request->indikator_sub_kegiatan_id[$key])->first();
                    $detailIndikatorProgram = DetailIndikatorSubKegiatan::create([
                        'detail_sub_kegiatan_id' => $detailSubKegiatan->id,
                        'sasaran_sub_kegiatan_id' => $value,
                        'nama_sasaran_sub_kegiatan' => $sasaranSubKegiatan->nama,
                        'indikator_sub_kegiatan_id' => $request->indikator_sub_kegiatan_id[$key],
                        'nama_indikator_sub_kegiatan' => $indikatorSubKegiatan->nama,
                        'target_indikator' => $request->target[$key],
                        'kondisi_awal' => $request->kondisi[$key],
                    ]);
                }
            }
            return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menambah Data Sub Kegiatan']);
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

        $detailKegiatan = detailSubKegiatan::where('id', $id)->first();

        if(count($detailKegiatan->detailIndikatorSubKegiatan) > 0){
            foreach ($detailKegiatan->detailIndikatorSubKegiatan as $key => $value) {
                # code...
                $value->delete();
            }
        }
        $detailKegiatan->delete();

        return redirect()->route('program_dan_kegiatan.index')->with(['success'=>'Berhasil Menghapus Data Sub Kegiatan']);
    }
}
