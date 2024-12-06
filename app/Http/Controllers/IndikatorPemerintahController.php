<?php

namespace App\Http\Controllers;

use App\Models\IndikatorPemerintah;
use App\Models\IndukOpd;
use App\Models\SasaranRpjmd;
use Illuminate\Http\Request;

class IndikatorPemerintahController extends Controller
{
    protected $routeName = 'indikator_pemerintah';
    protected $viewName = 'indikator_pemerintah';
    protected $title = 'Indikator Pemerintah';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $sasaranRpjmd = SasaranRpjmd::all();
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        return view('indikator_pemerintah.index',compact('route','title', 'sasaranRpjmd', 'induk_opd_arr'));

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
            IndikatorPemerintah::create($request->all());

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Indikator Pemerintah']);
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
        $indikatorPemerintah = IndikatorPemerintah::where('id', $id)->first();
        try {
            //code...
            $indikatorPemerintah->update($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Indikator Pemerintah '.$indikatorPemerintah->nama]);
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
        $indikatorPemerintah = IndikatorPemerintah::where('id', $id)->first();
        try {
            //code...
            $indikatorPemerintah->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Indikator Pemerintah '.$indikatorPemerintah->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $indikatorPemerintah = IndikatorPemerintah::where('id', $id)->first();
        $indukOpd = IndukOpd::all();


        return response()->json([
            'status' => 'success',
            'data' => $indikatorPemerintah,
            'IndukOpd' => $indukOpd,
        ]);
    }
}
