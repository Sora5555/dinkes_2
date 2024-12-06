<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class ObatEsensialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'ObatEsensial';
    protected $viewName = 'obat_esensial';
    protected $title = 'Obat Esensial';
    public function index(Request $request)
    {

        $unit_kerja = UnitKerja::all();
        $obat_tersedia = UnitKerja::whereRelation('ObatEsensial', 'status', 1)->count();
        $total_obat = UnitKerja::whereHas('ObatEsensial', function($query) {
            $query->where('status', '!=', 0);
        })->count();

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'obat_tersedia' => $obat_tersedia,
            'total_obat' => $total_obat,
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
        $unit_kerja = UnitKerja::where('id', $request->id)->first();
        $err = "";
        if($request->name == "diatas_80" && $unit_kerja->ObatEsensial->status == 0){
            $unit_kerja->ObatEsensial->update([
                'status' => 1,
            ]);
        } else if($request->name == "diatas_80" && $unit_kerja->ObatEsensial->status == 1){
            $unit_kerja->ObatEsensial->update([
                'status' => 0,
            ]);
        } else if($request->name == "dibawah_80" && $unit_kerja->ObatEsensial->status == 0){
            $unit_kerja->ObatEsensial->update([
                'status' => 2,
            ]);
        } else if($request->name == "dibawah_80" && $unit_kerja->ObatEsensial->status == 2){
            $unit_kerja->ObatEsensial->update([
                'status' => 0,
            ]);
        } else {
            $err = "Hanya Satu kondisi yang boleh di tentukan";
        }

        return response()->json([
            'status' => 'success',
            'err' => $err,
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
