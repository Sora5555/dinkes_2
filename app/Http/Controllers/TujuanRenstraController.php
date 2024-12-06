<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\visiRpjmd;
use App\Models\VisiRenstra;
use Illuminate\Http\Request;
use App\Models\TujuanRenstra;
use Illuminate\Support\Facades\Auth;

class TujuanRenstraController extends Controller
{
    protected $routeName = 'tujuan_renstra';
    protected $viewName = 'tujuan_renstra';
    protected $title = 'Tujuan Renstra';

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
           
            //code...
            if($request->misi_rpjmd_id != null && $request->misi_rpjmd_id != 'undefined' ){
                foreach ($request->nama as $key => $value) {
                    # code...
                    TujuanRenstra::create([
                        'nama' => $value,
                        'misi_rpjmd_id' => $request->misi_rpjmd_id,
                        'misi_renstra_id' => 0,
                        'induk_opd_id' => $request->induk_opd_id
                    ]);

                }
            } else {
                foreach ($request->nama as $key => $value) {
                    # code...
                    TujuanRenstra::create([
                        'nama' => $value,
                        'sasaran_rpjmd_id' => 0,
                        'misi_renstra_id' => $request->misi_renstra_id,
                        'induk_opd_id' => $request->induk_opd_id,
                    ]);

                }
            }
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Tujuan']);
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
        $tujuanRenstra = TujuanRenstra::where('id', $id)->first();
        try {
            //code...
            $tujuanRenstra->update([
                'nama' => $request->nama,
            ]);

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Edit Data Tujuan Renstra: '.$tujuanRenstra->nama]);
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
        $tujuanRenstra = TujuanRenstra::where('id', $id)->first();

        try {
            //code...
            $tujuanRenstra->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Tujuan: '.$tujuanRenstra->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function apiEdit($id){
        $tujuanRenstra = TujuanRenstra::where('id', $id)->first();
        if($tujuanRenstra){
            return response()->json([
                'status' => 'success',
                'data' => $tujuanRenstra,
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'data' => '',
            ]);
        }

    }
}
