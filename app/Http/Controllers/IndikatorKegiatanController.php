<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorKegiatan;
use App\Models\IndikatorKegiatan;
use Illuminate\Http\Request;

class IndikatorKegiatanController extends Controller
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
            $indikatorKegiatan = IndikatorKegiatan::create($request->all());
            $detailIndikatorKegiatan = detailIndikatorKegiatan::where('sasaran_kegiatan_id', $request->sasaran_kegiatan_id)->first();

            if($detailIndikatorKegiatan){
                $detailIndikatorKegiatan->update([
                    'indikator_kegiatan_id' => $indikatorKegiatan->id,
                    'nama_indikator_kegiatan' => $request->nama,
                ]);
            }

            return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Menambah data Indikator Kegiatan : '.$indikatorKegiatan->id]);
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
        $indikatorKegiatan = IndikatorKegiatan::find($id);
        try {
            //code...
            $indikatorKegiatan->update([
                'nama' => $request->nama
            ]);
            $detailKegiatan = detailIndikatorKegiatan::where('indikator_kegiatan_id', $id)->first();
            $detailKegiatan->update([
            'nama_indikator_kegiatan' => $request->nama,
            ]);

            return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Menambah data Indikator Kegiatan : '.$indikatorKegiatan->id]);
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
        $indikatorKegiatan = IndikatorKegiatan::find($id);
        $detailIndikatorKegiatan = detailIndikatorKegiatan::where("indikator_kegiatan_id", $id)->first();
        try {
            //code...
            if($detailIndikatorKegiatan){
                $detailIndikatorKegiatan->update([
                    'indikator_kegiatan_id' => null,
                    'nama_indikator_kegiatan' => null,
                ]);
            }
            $indikatorKegiatan->delete();

            return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Menghapus data Indikator Kegiatan : '.$indikatorKegiatan->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $indikatorKegiatan = IndikatorKegiatan::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $indikatorKegiatan,
        ]);
    }
}
