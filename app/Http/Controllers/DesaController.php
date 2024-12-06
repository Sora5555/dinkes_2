<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IbuHamilDanBersalin;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ protected $routeName = 'desa';
    protected $viewName = 'desa';
    protected $title = 'desa';
    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $desa = Desa::all();
        return view('desa.index',compact('route','title','desa'));
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
            $desa = Desa::create($request->all());
            IbuHamilDanBersalin::create([
                'k1' => 0,
                'k4' => 0,
                'k6' => 0,
                'fasyankes' => 0,
                'kf1' => 0,
                'kf_lengkap' => 0,
                'vita' => 0,
                'desa_id' => $desa->id,
            ]);


            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Desa']);
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
        $desa = Desa::where('id', $id)->first();
        try {
            $desa->update($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Sub Kegiatan']);
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
        $desa = Desa::where('id', $id)->first();
        try {
            $desa->delete();
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menghapus Data Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function api(){

        $unitKerja = UnitKerja::all();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::all();
        $data = Desa::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'unitKerja' => $unitKerja,
        ]);
    }
}
