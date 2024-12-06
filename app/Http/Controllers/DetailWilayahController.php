<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'DetailWilayah';
    protected $viewName = 'detail_wilayah';
    protected $title = 'Detail Wilayah';
    public function index(Request $request)
    {

        $unit_kerja = UnitKerja::all();
        $total_luas_wilayah = 0;
        $total_desa = 0;
        $total_kelurahan = 0;
        $total_jumlah_penduduk = 0;
        $total_jumlah_rumah_tangga = 0;

        $indukOpd = IndukOpd::pluck('nama', 'id');
            foreach($unit_kerja as $puskesmas){
                $total_luas_wilayah += $puskesmas->luas_wilayah;
                $total_desa += $puskesmas->Desa()->count();
                $total_kelurahan += $puskesmas->kelurahan;
                $total_jumlah_penduduk += $puskesmas->jumlah_penduduk;
                $total_jumlah_rumah_tangga += $puskesmas->jumlah_rumah_tangga;
            }

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' =>  $unit_kerja,
            'total_luas_wilayah' => $total_luas_wilayah,
            'total_desa' => $total_desa,
            'total_kelurahan' => $total_kelurahan,
            'total_jumlah_penduduk' => $total_jumlah_penduduk,
            'total_jumlah_rumah_tangga' => $total_jumlah_rumah_tangga,
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
        $unit_kerja = UnitKerja::where("id", $request->id)->first();
        $unit_kerja->update([
            $request->name => $request->value,
        ]);
        $desaKelurahan = $unit_kerja->kelurahan + $unit_kerja->Desa()->count();
        $rata_rata_rumah_tangga = $unit_kerja->jumlah_rumah_tangga > 0?(number_format($unit_kerja->jumlah_penduduk/$unit_kerja->jumlah_rumah_tangga * 100)):0;
        $kepadatanPenduduk = $unit_kerja->luas_wilayah > 0?(number_format($unit_kerja->jumlah_penduduk/$unit_kerja->luas_wilayah * 100)):0;
        return response()->json([
            'status' => 'success',
            'desaKelurahan' => $desaKelurahan,
            'rata_rata_rumah_tangga' => $rata_rata_rumah_tangga,
            'kepadatanPenduduk' => $request->kepadatanPenduduk,
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
