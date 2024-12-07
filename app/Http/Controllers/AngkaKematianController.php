<?php

namespace App\Http\Controllers;

use App\Models\AngkaKematian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AngkaKematianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'AngkaKematian';
    protected $viewName = 'angka_kematian';
    protected $title = 'Angka Kematian';
    public function index()
    {
        //
        $AngkaKematian = AngkaKematian::whereYear('created_at', Session::get('year'))->get();
        $total_tempat_tidur = 0;
        $total_pasien_keluar_hidup_mati_L = 0;
        $total_pasien_keluar_hidup_mati_P = 0;
        $total_pasien_keluar_mati_L = 0;
        $total_pasien_keluar_mati_P = 0;
        $total_pasien_keluar_mati_48_L = 0;
        $total_pasien_keluar_mati_48_P = 0;
        foreach($AngkaKematian as $ak){
            $total_tempat_tidur += $ak->jumlah_tempat_tidur;
            $total_pasien_keluar_hidup_mati_L += $ak->pasien_keluar_hidup_mati_L;
            $total_pasien_keluar_hidup_mati_P += $ak->pasien_keluar_hidup_mati_P;
            $total_pasien_keluar_mati_L += $ak->pasien_keluar_mati_L;
            $total_pasien_keluar_mati_P += $ak->pasien_keluar_mati_P;
            $total_pasien_keluar_mati_48_L += $ak->pasien_keluar_mati_48_L;
            $total_pasien_keluar_mati_48_P += $ak->pasien_keluar_mati_48_P;
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'AngkaKematian' => $AngkaKematian,
            'total_tempat_tidur' => $total_tempat_tidur,
            'total_pasien_keluar_hidup_mati_L' => $total_pasien_keluar_hidup_mati_L,
            'total_pasien_keluar_hidup_mati_P' => $total_pasien_keluar_hidup_mati_P,
            'total_pasien_keluar_mati_L' => $total_pasien_keluar_mati_L,
            'total_pasien_keluar_mati_P' => $total_pasien_keluar_mati_P,
            'total_pasien_keluar_mati_48_L' => $total_pasien_keluar_mati_48_L,
            'total_pasien_keluar_mati_48_P' => $total_pasien_keluar_mati_48_P,
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
        $jumlah_pasien_keluar_hidup_mati = $angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P;
        $jumlah_pasien_keluar_mati = $angkaKematian->pasien_keluar_mati_L + $angkaKematian->pasien_keluar_mati_P;
        $jumlah_pasien_keluar_mati_48 = $angkaKematian->pasien_keluar_mati_48_L + $angkaKematian->pasien_keluar_mati_48_P;
        $gross_death_rate_L = $angkaKematian->pasien_keluar_hidup_mati_L>0?number_format($angkaKematian->pasien_keluar_mati_L/$angkaKematian->pasien_keluar_hidup_mati_L * 100, 2):0;
        $gross_death_rate_P = $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format($angkaKematian->pasien_keluar_mati_P/$angkaKematian->pasien_keluar_hidup_mati_P * 100, 2):0;
        $gross_death_rate_LP = $angkaKematian->pasien_keluar_hidup_mati_P + $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format(($angkaKematian->pasien_keluar_mati_P + $angkaKematian->pasien_keluar_mati_L)/($angkaKematian->pasien_keluar_hidup_mati_P + $angkaKematian->pasien_keluar_hidup_mati_L) * 100, 2):0;

        $net_death_rate_L = $angkaKematian->pasien_keluar_mati_48_L>0?number_format($angkaKematian->pasien_keluar_mati_L/$angkaKematian->pasien_keluar_mati_48_L * 100, 2):0;
        $net_death_rate_P = $angkaKematian->pasien_keluar_mati_48_P>0?number_format($angkaKematian->pasien_keluar_mati_P/$angkaKematian->pasien_keluar_mati_48_P * 100, 2):0;
        $net_death_rate_LP = $angkaKematian->pasien_keluar_mati_48_P + $angkaKematian->pasien_keluar_mati_48_P>0?number_format(($angkaKematian->pasien_keluar_mati_P + $angkaKematian->pasien_keluar_mati_L)/($angkaKematian->pasien_keluar_mati_48_P + $angkaKematian->pasien_keluar_mati_48_L) * 100, 2):0;

        return response()->json([
            'status' => 'success',
            'jumlah_pasien_keluar_hidup_mati' => $jumlah_pasien_keluar_hidup_mati,
            'jumlah_pasien_keluar_mati' => $jumlah_pasien_keluar_mati,
            'jumlah_pasien_keluar_mati_48' => $jumlah_pasien_keluar_mati_48,
            'gross_death_rate_L' => $gross_death_rate_L,
            'gross_death_rate_P' => $gross_death_rate_P,
            'gross_death_rate_LP' => $gross_death_rate_LP,
            'net_death_rate_L' => $net_death_rate_L,
            'net_death_rate_P' => $net_death_rate_P,
            'net_death_rate_LP' => $net_death_rate_LP,
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
