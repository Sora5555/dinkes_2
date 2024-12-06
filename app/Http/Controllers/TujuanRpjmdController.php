<?php

namespace App\Http\Controllers;

use App\Models\TujuanRpjmd;
use App\Models\visiRpjmd;
use Illuminate\Http\Request;

class TujuanRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'tujuan_rpjmd';
    protected $viewName = 'tujuan_rpjmd';
    protected $title = 'Tujuan RPJMD';
    public function index()
    {
        //
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
            'visi'=>visiRpjmd::all(),
        ];
        return view($this->routeName.'.index')->with($data);
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
            $tujuanRpjmd = TujuanRpjmd::create([
                'misi_rpjmd_id' => $request->misi_rpjmd_id,
                'nama' => $value,
            ]);
        }
        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Tujuan RPJMD']);
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
        $tujuanRpjmd = TujuanRpjmd::where('id', $id)->first();
        try {
            $tujuanRpjmd->update([
                'nama' => $request->nama,
            ]);
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Tujuan RPJMD: '.$tujuanRpjmd->nama]);
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
        $tujuanRpjmd = TujuanRpjmd::where('id', $id)->first();
        try {
            $tujuanRpjmd->delete();
            //code...
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menghapus Data Tujuan RPJMD: '.$tujuanRpjmd->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $tujuanRpjmd = TujuanRpjmd::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $tujuanRpjmd,
        ]);
    }
}
