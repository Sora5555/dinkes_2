<?php

namespace App\Http\Controllers;

use App\Models\AngkaKematian;
use Illuminate\Http\Request;

class IndikatorKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'IndikatorKinerja';
    protected $viewName = 'indikator_kinerja';
    protected $title = 'Indikator Kinerja';
    public function index()
    {
        //
        $AngkaKematian = AngkaKematian::all();
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'AngkaKematian' => $AngkaKematian,
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
        $angkaKematian = AngkaKematian::where('id', $request->id)->first();
        $angkaKematian->update([
            $request->name => $request->value,
        ]);
        $bor = $angkaKematian->jumlah_tempat_tidur>0?number_format($angkaKematian->jumlah_hari_perawatan/($angkaKematian->jumlah_tempat_tidur * 365) * 100, 2):0;
        $bto = $angkaKematian->jumlah_tempat_tidur>0?number_format(($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P)/$angkaKematian->jumlah_tempat_tidur, 2):0;
        $toi = $angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format((($angkaKematian->jumlah_tempat_tidur * 365) - $angkaKematian->jumlah_hari_perawatan)/($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P), 2):0;
        $alos = $angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format($angkaKematian->jumlah_lama_dirawat/($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P), 2):0;
        return response()->json([
            'status' => 'success',
            'bor' => $bor,
            'bto' => $bto,
            'toi' => $toi,
            'alos' => $alos,
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
