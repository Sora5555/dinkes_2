<?php

namespace App\Http\Controllers;

use App\Models\MisiRpjmd;
use App\Models\visiRpjmd;
use Illuminate\Http\Request;

class MisiRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'misi_rpjmd';
    protected $viewName = 'misi_rpjmd';
    protected $title = 'Misi RPJMD';
    public function index()
    {
        //
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
            // 'visi'=>visiRpjmd::all(),
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
            MisiRpjmd::create([
                "visi_rpjmd_id" => $request->visi_rpjmd_id,
                'nama' => $value,
            ]);
        }
        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Misi RPJMD']);
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
        $misiRpjmd = MisiRpjmd::where('id', $id)->first();

        try {
            $misiRpjmd->update([
                'nama' => $request->nama
            ]);
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Misi RPJMD: '.$misiRpjmd->nama]);
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
        $misiRpjmd = MisiRpjmd::where('id', $id)->first();
        try {
            //code...
            $misiRpjmd->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menghapus Data Misi RPJMD: '.$misiRpjmd->nama]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $visiRpjmd = MisiRpjmd::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $visiRpjmd,
        ]);
    }
}
