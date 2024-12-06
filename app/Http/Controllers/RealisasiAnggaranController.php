<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\detailKegiatan;
use Illuminate\Support\Facades\Auth;

class RealisasiAnggaranController extends Controller
{
    protected $routeName = 'realisasi_anggaran';
    protected $viewName = 'realisasi_anggaran';
    protected $title = 'Realisasi Anggaran';

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
        return view('realisasi_anggaran.index',compact('route','title', 'induk_opd_arr'));

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
        try {
            //code...
            $detailKegiatan = SubKegiatan::find($id)->first();
            $detailKegiatan->update([
                'rp_tri_1' => $request->tw_1,
                'rp_tri_2' => $request->tw_2,
                'rp_tri_3' => $request->tw_3,
                'rp_tri_4' => $request->tw_4,
            ]);

            return redirect(route('realisasi_anggaran.index'))->with(['success'=>'Berhasil Menambah data Realisasi Anggaran']);
        } catch (\Throwable $th) {
            //throw $th;
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
}
