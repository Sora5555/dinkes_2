<?php

namespace App\Http\Controllers;

use App\Models\DetailIndikatorSubKegiatan;
use App\Models\IndikatorSubKegiatan;
use Illuminate\Http\Request;

class indikatorSubKegiatanController extends Controller
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
            //code...
            $detailIndikatorSubKegiatan = DetailIndikatorSubKegiatan::where('sasaran_sub_kegiatan_id', $request->sasaran_sub_kegiatan_id)->first();
            $indikatorSubKegiatan = IndikatorSubKegiatan::create([
                'sasaran_sub_kegiatan_id' => $request->sasaran_sub_kegiatan_id,
                'nama' => $request->nama,
            ]);
            if($detailIndikatorSubKegiatan){
                $detailIndikatorSubKegiatan->update([
                    'indikator_sub_kegiatan_id' => $indikatorSubKegiatan->id,
                    'nama_indikator_sub_kegiatan' => $request->nama,
                ]);
            }

            return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil menambahkan Data Indikator Sub Kegiatan']);
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
       $indikatorSubKegiatan = IndikatorSubKegiatan::find($id);
       $detailIndikatorSubKegiatan = DetailIndikatorSubKegiatan::where('indikator_sub_kegiatan_id', $id)->first();

       try {
        $indikatorSubKegiatan->update([
            'nama' => $request->nama,
        ]);
        if($detailIndikatorSubKegiatan){
            $detailIndikatorSubKegiatan->update([
                'nama_indikator_sub_kegiatan' => $request->nama,
            ]);
        }

        return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil Mengubah Data Indikator Sub Kegiatan']);
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
        $indikatorSubKegiatan = IndikatorSubKegiatan::find($id);
        $detailIndikatorSubKegiatan = DetailIndikatorSubKegiatan::where('indikator_sub_kegiatan_id', $id)->first();
        try {
            //code...
            if($detailIndikatorSubKegiatan){
                $detailIndikatorSubKegiatan->update([
                    'nama_indikator_sub_kegiatan' => null,
                    'indikator_sub_kegiatan_id' => null,
                ]);
            }
            $indikatorSubKegiatan->delete();

            return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil Menghapus Data Indikator Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $sasaranSubKegiatan = IndikatorSubKegiatan::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $sasaranSubKegiatan,
        ]);
    }
}
