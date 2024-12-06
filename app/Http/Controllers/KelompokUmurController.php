<?php

namespace App\Http\Controllers;

use App\Models\KelompokUmur;
use Illuminate\Http\Request;

class KelompokUmurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'KelompokUmur';
    protected $viewName = 'kelompok_umur';
    protected $title = 'Kelompok Umur';
    public function index()
    {
        //
        $kelompokUmur = KelompokUmur::all();
        $total_laki_laki = 0;
        $total_perempuan = 0;
        foreach($kelompokUmur as $umur){
            $total_laki_laki += $umur->laki_laki;
            $total_perempuan += $umur->perempuan;
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'kelompokUmur' => $kelompokUmur,
            'total_laki_laki' => $total_laki_laki,
            'total_perempuan' => $total_perempuan,
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
        $kelompokUmur = KelompokUmur::where('id', $request->id)->first();
        $kelompokUmur->update([
            $request->name => $request->value,
        ]);
        $total_laki_laki_perempuan = $kelompokUmur->laki_laki + $kelompokUmur->perempuan;
        $rasio = $kelompokUmur->perempuan > 0?number_format($kelompokUmur->laki_laki/$kelompokUmur->perempuan * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'total_laki_laki_perempuan' => $total_laki_laki_perempuan,
            'rasio' => $rasio,
        ]);
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
