<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\visiRpjmd;
use App\Models\VisiRenstra;
use Illuminate\Http\Request;
use App\Models\SasaranRenstra;
use App\Models\IndikatorPemerintah;
use Illuminate\Support\Facades\Auth;

class IndikatorOpdController extends Controller
{
    protected $routeName = 'indikator_opd';
    protected $viewName = 'indikator_opd';
    protected $title = 'Indikator OPD';

    public function index()
    {
        //
        $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'visi' => visiRpjmd::all(),
            'visiRenstra' => VisiRenstra::all()
        ];
        return view('indikator_opd.index')->with($data);

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
            foreach ($request->indikator_pemerintah as $key => $value) {
                # code...
                $sasaranRenstra = SasaranRenstra::where('id', $value)->first();

                $sasaranRenstra->update([
                    'indikator_pemerintah_id' => $id,
                ]);
            
            }
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Indikator']);    
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
        $sasaranRenstra = SasaranRenstra::where('id', $id)->first();
        try {
            //code...
            $sasaranRenstra->update([
                'indikator_pemerintah_id' => 0
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Indikator']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $sasaranRenstra = SasaranRenstra::where('induk_opd_id', $id)->where('indikator_pemerintah_id', 0)->get();


        return response()->json([
            'status' => 'success',
            'data' => $sasaranRenstra,
        ]);
    }
}
