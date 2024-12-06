<?php

namespace App\Http\Controllers;

use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;

class FasilitasKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Fasilitas Kesehatan';
    protected $viewName = 'fasilitas_kesehatan';
    protected $title = 'Fasilitas Kesehatan';
    public function index()
    {
        //
        $RumahSakit = FasilitasKesehatan::where('tipe', 'RUMAH SAKIT')->get();
        $Puskesmas = FasilitasKesehatan::where('tipe', 'PUSKESMAS DAN JARINGANNYA')->get();
        $Farmasi = FasilitasKesehatan::where('tipe', 'PUSKESMAS DAN SARANA PRODUKSI DAN DISTRIBUSI KEFARMASIAN')->get();
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'RumahSakit' => $RumahSakit,
            'Puskesmas' => $Puskesmas,
            'Farmasi' => $Farmasi,

        ];
        return view($this->viewName.'.index')->with($data);
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
        $FasilitasKesehatan = FasilitasKesehatan::where('id', $request->id)->first();
        $FasilitasKesehatan->update([
            $request->name => $request->value,
        ]);
        $total = $FasilitasKesehatan->kemenkes + $FasilitasKesehatan->pemprov + $FasilitasKesehatan->pemkot + $FasilitasKesehatan->tni_polri + $FasilitasKesehatan->bumn + $FasilitasKesehatan->ormas + $FasilitasKesehatan->swasta;
        return response()->json([
            'status' => 'success',
            'total' => $total,
        ]);
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
    }
}
