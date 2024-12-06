<?php

namespace App\Http\Controllers;

use App\Models\JumlahPenduduk;
use Illuminate\Http\Request;

class JumlahPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'jumlah_penduduk';
    protected $viewName = 'jumlah_penduduk';
    protected $title = 'jumlah_penduduk';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     KesehatanBalita::create([
        //         'desa_id' => $value->id,
        //         'balita_0_59' => 0,
        //         'balita_12_59' => 0,
        //         'balita_kia' => 0,
        //         'balita_dipantau' => 0,
        //         'balita_sdidtk' => 0,
        //         'balita_mtbs' => 0,
        //     ]);
        // }
    $jumlah_penduduk = JumlahPenduduk::all();

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'jumlah_penduduk' =>  $jumlah_penduduk,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
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
            $jumlah_penduduk = JumlahPenduduk::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $jumlah_penduduk->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $jumlah = (int)$jumlah_penduduk->laki_laki + (int)$jumlah_penduduk->perempuan;
            $persen = (int)$jumlah_penduduk->laki_laki/$jumlah_penduduk->perempuan*100;
            // $desa = $IbuHamil->Desa->UnitKerja;
            // $total = 0;

            // foreach ($desa->desa as $key => $value) {
            //     # code...
            //     // dd($value);
            //     $total += $value->filterDesa($request->params)->{$request->name};
            // }
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'persen' => $persen,
                'jumlah' => $jumlah,
                // 'total' => $total,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage(),
            ]);
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
