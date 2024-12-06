<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\detailKegiatan;
use Illuminate\Support\Facades\Auth;

class PaguAnggaranController extends Controller
{
    protected $routeName = 'pagu_anggaran';
    protected $viewName = 'pagu_anggaran';
    protected $title = 'Pagu Anggaran';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $induk_opd_arr = $indukOpd;
        return view('pagu_anggaran.index',compact('route','title', 'induk_opd_arr'));

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
        $subKegiatan = SubKegiatan::find($id);

        try {
            $subKegiatan->update([
                'pagu_indikatif' => $request->pagu_indikatif,
            ]);

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Pagu Kegiatan: '.$subKegiatan->nama_kegiatan]);
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
    }
    public function apiEdit($id){

        $detailKegiatan = SubKegiatan::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $detailKegiatan,
        ]);
    }
}
