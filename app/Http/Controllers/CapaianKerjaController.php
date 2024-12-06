<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\IndikatorOpd;
use Illuminate\Http\Request;
use App\Models\IndikatorPemerintah;
use Illuminate\Support\Facades\Auth;

class CapaianKerjaController extends Controller
{
    protected $routeName = 'capaian_kerja';
    protected $viewName = 'capaian_kerja';
    protected $title = 'Capaian Kerja';

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
        return view('capaian_kerja.index',compact('route','title', 'induk_opd_arr'));

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
            if($request->indikator_pemerintah_id){
                $indikator = IndikatorPemerintah::where('id', $id)->first();
                $indikator->update([
                    'capaian_satu' => $request->capaian_satu,
                    'capaian_dua' => $request->capaian_dua,
                    'capaian_tiga' => $request->capain_tiga,
                    'capaian_empat' => $request->capaian_empat
                ]);
            } else{
                $indikator = IndikatorOpd::where('id', $id)->first();
                $indikator->update([
                    'capaian_satu' => $request->capaian_satu,
                    'capaian_dua' => $request->capaian_dua,
                    'capaian_tiga' => $request->capaian_tiga,
                    'capaian_empat' => $request->capaian_empat
                ]);
            }

            return redirect(route('capaian_kerja.index'))->with(['success'=>'Berhasil Menambah data Capaian Kerja']);
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
