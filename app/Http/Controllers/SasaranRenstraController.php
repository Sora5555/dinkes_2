<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\visiRpjmd;
use App\Models\VisiRenstra;
use Illuminate\Http\Request;
use App\Models\SasaranRenstra;
use Illuminate\Support\Facades\Auth;

class SasaranRenstraController extends Controller
{
    protected $routeName = 'sasaran_renstra';
    protected $viewName = 'sasaran_renstra';
    protected $title = 'Sasaran Renstra';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        try {
            foreach ($request->nama as $key => $value) {
                # code...
                $sasaranRenstra = SasaranRenstra::create([
                    'nama' => $value,
                    'tujuan_renstra_id' => $request->tujuan_renstra_id,
                    'induk_opd_id' => $request->induk_opd_id,
                    'indikator_pemerintah_id' => 0
                ]);
            }
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Sasaran']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        dd($request->all());
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
        $sasaranRenstra = SasaranRenstra::where('id', $id)->first();
        try {
            //code...
            $sasaranRenstra->update([
                'nama' => $request->nama,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Sasaran: '. $sasaranRenstra->nama]);
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
            $sasaranRenstra->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Sasaran: '. $sasaranRenstra->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $sasaranRenstra = SasaranRenstra::where('id', $id)->first();
        if($sasaranRenstra){
            return response()->json([
                'status' => 'success',
                'data' => $sasaranRenstra,
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'data' => '',
            ]);
        }

    }
}
