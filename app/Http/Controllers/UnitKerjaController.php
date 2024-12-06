<?php

namespace App\Http\Controllers;

use App\Models\AhliLabMedik;
use App\Models\Apoteker;
use App\Models\Bidan;
use App\Models\Dokter;
use App\Models\DokterGigi;
use App\Models\DokterGigiSpesialis;
use App\Models\DokterSpesialis;
use App\Models\IndukOpd;
use App\Models\KeteknisanMedik;
use App\Models\Manajemen;
use App\Models\PejabatStruktural;
use App\Models\Perawat;
use App\Models\Posyandu;
use App\Models\TenagaGizi;
use App\Models\TenagaKesehatanLingkungan;
use App\Models\TenagaKesehatanMasyarakat;
use App\Models\TenagaPendidik;
use App\Models\TenagaTeknikBiomedik;
use App\Models\TenagaTeknisFarmasi;
use App\Models\TerapiFisik;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'unit_kerja';
    protected $viewName = 'unit_kerja';
    protected $title = 'Unit Kerja';
    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $unit_kerja = UnitKerja::all();
        return view('unit_kerja.index',compact('route','title','unit_kerja'));
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
            $unitKerja = UnitKerja::create([
                'nama' => $request->nama,
                'induk_opd_id' => $request->induk_opd_id,
                'tipe' => "Puskesmas",
                'kecamatan' => $request->kecamatan,
            ]);
            AhliLabMedik::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaTeknikBiomedik::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TerapiFisik::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            KeteknisanMedik::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaKesehatanMasyarakat::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaKesehatanLingkungan::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaGizi::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Perawat::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Bidan::create([
                'unit_kerja_id' => $unitKerja->id,
                'perempuan' => 0,
            ]);
            DokterSpesialis::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Dokter::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            DokterGigi::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            DokterGigiSpesialis::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaTeknisFarmasi::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Apoteker::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            PejabatStruktural::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            TenagaPendidik::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Manajemen::create([
                'unit_kerja_id' => $unitKerja->id,
                'laki_laki' => 0,
                'perempuan' => 0,
            ]);
            Posyandu::create([
                'unit_kerja_id' => $unitKerja->id,
                'pratama' => 0,
                'madya' => 0,
                'purnama' => 0,
                'mandiri' => 0,
                'aktif' => 0,
                'posbindu' => 0,
            ]);
            return redirect()->route('unit_kerja.index')->with(['success'=>'Berhasil menambahkan Data Unit Kerja']);
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
        try {
            $unitKerja = UnitKerja::where('id', $id)->first();

            $unitKerja->update([
                'nama' => $request->nama,
                'kecamatan' => $request->kecamatan,
            ]);

            return redirect()->route('unit_kerja.index')->with(['success'=>'Berhasil edit Data Unit Kerja']);
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
        try {
            $unitKerja = UnitKerja::where('id', $id)->first();
            $unitKerja->DokterSpesialis->delete();
            $unitKerja->Dokter->delete();
            $unitKerja->DokterGigi->delete();
            $unitKerja->DokterGigiSpesialis->delete();
            $unitKerja->Perawat->delete();
            $unitKerja->Bidan->delete();
            $unitKerja->TenagaKesehatanLingkungan->delete();
            $unitKerja->TenagaKesehatanMasyarakat->delete();
            $unitKerja->TenagaGizi->delete();
            $unitKerja->AhliLabMedik->delete();
            $unitKerja->TenagaTeknikBiomedik->delete();
            $unitKerja->TenagaTeknikFarmasi->delete();
            $unitKerja->KeteknisanMedik->delete();
            $unitKerja->Apoteker->delete();
            $unitKerja->PejabatStruktural->delete();
            $unitKerja->TenagaPendidik->delete();
            $unitKerja->Manajemen->delete();
            $unitKerja->Posyandu->delete();
            $unitKerja->delete();
            return redirect()->route('unit_kerja.index')->with(['success'=>'Berhasil edit Data Unit Kerja']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function api(){

        if(Auth::user()->roles->first()->name == "Admin"){
            $indukOpd = IndukOpd::all();
        } else {
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->get();
        }


        return response()->json([
            'status' => 'success',
            'data' => $indukOpd,
        ]);
    }
    public function apiEdit($id){

        if(Auth::user()->roles->first()->name == "Admin"){
            $indukOpd = IndukOpd::all();
        } else {
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->get();
        }

        $data = UnitKerja::where('id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'indukOpd' => $indukOpd,
        ]);
    }

}
