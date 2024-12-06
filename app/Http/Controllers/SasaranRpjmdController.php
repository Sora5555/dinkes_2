<?php

namespace App\Http\Controllers;

use App\Models\SasaranRpjmd;
use App\Models\visiRpjmd;
use Illuminate\Http\Request;

class SasaranRpjmdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'sasaran_rpjmd';
    protected $viewName = 'sasaran_rpjmd';
    protected $title = 'Sasaran RPJMD';
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
                $sasaranRpjmd = SasaranRpjmd::create([
                    'nama' => $value,
                    'tujuan_rpjmd_id' => $request->tujuan_rpjmd_id,
                ]);
            }
             return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Sasaran RPJMD']);
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
       $sasaranRpjmd = SasaranRpjmd::where('id', $id)->first();
       try {
        //code...
        $sasaranRpjmd->update([
            'nama' => $request->nama,
        ]);
        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data Sasaran RPJMD: '.$sasaranRpjmd->nama]);
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
        $sasaranRpjmd = SasaranRpjmd::where('id', $id)->first();
        try {
            $sasaranRpjmd->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Menghapus Data Sasaran RPJMD: '.$sasaranRpjmd->nama]);
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiEdit($id){
        $sasaranRpjmd = SasaranRpjmd::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $sasaranRpjmd,
        ]);
    }
}
