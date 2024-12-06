<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detailSubKegiatan;
use App\Models\SasaranSubKegiatan;
use App\Models\DetailIndikatorSubKegiatan;

class sasaranSubKegiatanController extends Controller
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

            $detailSubKegiatan = detailSubKegiatan::where('sub_kegiatan_id', $request->sub_kegiatan_id)->first();
            $sasaranSubKegiatan = SasaranSubKegiatan::create([
                'nama' => $request->nama,
                'sub_kegiatan_id' => $request->sub_kegiatan_id,
            ]);

            if($detailSubKegiatan){
                DetailIndikatorSubKegiatan::create([
                    'detail_sub_kegiatan_id' => $detailSubKegiatan->id,
                    'nama_sasaran_sub_kegiatan' => $request->nama,
                    'sasaran_sub_kegiatan_id' => $sasaranSubKegiatan->id,
                ]);
            }

            return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil menambahkan Data Sasaran Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
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
       $sasaranSubKegiatan = SasaranSubKegiatan::find($id);
       $detailIndikatorSubKegiatan = DetailIndikatorSubKegiatan::where('sasaran_sub_kegiatan_id', $id)->first();

       try {
        $sasaranSubKegiatan->update([
            'nama' => $request->nama,
        ]);
        if($detailIndikatorSubKegiatan){
            $detailIndikatorSubKegiatan->update([
                'nama_sasaran_sub_kegiatan' => $request->nama,
            ]);
        }

         return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil Mengubah Data Sasaran Sub Kegiatan']);
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
        $sasaranSubKegiatan = SasaranSubKegiatan::find($id);
        $detailIndikatorSubKegiatan = DetailIndikatorSubKegiatan::where('sasaran_sub_kegiatan_id', $id)->first();
        try {
            //code...
            $sasaranSubKegiatan->delete();
            if($detailIndikatorSubKegiatan){
                $detailIndikatorSubKegiatan->delete();
            }

            return redirect()->route('sub_kegiatan.index')->with(['success'=>'Berhasil Menghapus Data Sasaran Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function apiEdit($id){

        $sasaranSubKegiatan = SasaranSubKegiatan::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $sasaranSubKegiatan,
        ]);
    }
}
