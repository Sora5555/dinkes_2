<?php

namespace App\Http\Controllers;

use App\Models\detailIndikatorKegiatan;
use App\Models\detailKegiatan;
use App\Models\SasaranKegiatan;
use Illuminate\Http\Request;

class SasaranKegiatanController extends Controller
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
        $detailKegiatan = detailKegiatan::where('kegiatan_id', $request->kegiatan_id)->first();
        $sasaranKegiatan = SasaranKegiatan::create($request->all());

        if($detailKegiatan){
            $detailIndikatorKegiatan = detailIndikatorKegiatan::create([
                'detail_kegiatan_id' => $detailKegiatan->id,
                'nama_sasaran_kegiatan' => $request->nama,
                'sasaran_kegiatan_id' => $sasaranKegiatan->id,
            ]);
        }

        return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Menambah data sasaran Kegiatan : '.$sasaranKegiatan->id]);

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
       $sasaranKegiatan = SasaranKegiatan::find($id); //
       $detailIndikatorKegiatan = detailIndikatorKegiatan::where('sasaran_kegiatan_id', $id)->first();
       try {
        //code...
        $sasaranKegiatan->update([
            'nama' => $request->nama,
        ]);
        if($detailIndikatorKegiatan){
            $detailIndikatorKegiatan->update([
                'nama_sasaran_kegiatan' => $request->nama,
            ]);
        }
        $detailKegiatan = detailIndikatorKegiatan::where('sasaran_kegiatan_id', $id)->first();
        $detailKegiatan->update([
            'nama_sasaran_kegiatan' => $request->nama,
        ]);
        

        return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Mengubah data sasaran Kegiatan : '.$sasaranKegiatan->id]);
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
        $sasaranKegiatan = SasaranKegiatan::find($id);
        $detailIndikatorKegiatan = detailIndikatorKegiatan::where('sasaran_kegiatan_id', $id)->first();
        try {
            if($detailIndikatorKegiatan){
                $detailIndikatorKegiatan->delete();
            }
            $sasaranKegiatan->delete();

            return redirect(route('kegiatan.index'))->with(['success'=>'Berhasil Menghapus data sasaran Kegiatan : '.$sasaranKegiatan->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){

        $sasaranKegiatan = Sasarankegiatan::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $sasaranKegiatan,
        ]);
    }
}
