<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DokterGigi;
use App\Models\DokterGigiSpesialis;
use App\Models\DokterSpesialis;
use Exception;
use Throwable;
use App\Models\Log;
use App\Models\Target;
use App\Models\Jabatan;
use App\Models\Tagihan;
use App\Models\Golongan;
use App\Models\IndukOpd;
use App\Models\Pemangku;
use App\Models\Pelunasan;
use App\Models\UnitKerja;
use App\Models\UptDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PemangkuController extends Controller
{
    protected $routeName = 'pemangku';
    protected $viewName = 'pemangku';
    protected $title = 'Pemangku';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $title = $this->title;
        $route = $this->routeName;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $induk_opd_arr = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        // $golongan = Golongan::pluck('nama', 'id');
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::all();
        }
        return view('pemangku.index', compact('title', 'route', 'induk_opd_arr', 'unit_kerja'));
    }

    public function dataTable(Request $request)
    {
        $model = Jabatan::where('induk_opd_id', $request->induk_opd)->get();

        $modelArr = [];

        $nameArrCheck = [];

        $idArrCheck = [];

        foreach ($model as $key => $value) {
            if($value->descendants()->count() > 0){
                $variable = $value->descendantsAndSelf()->get();
                foreach ($variable as $key => $value1) {
                    # code...
                    if(!in_array($value1->nama, $nameArrCheck)){
                            array_push($nameArrCheck, $value1->nama);
                            array_push($modelArr, $value1);
                        }
                }
            } else {
                if($value->descendants()->count() == 0 && !in_array($value->nama, $nameArrCheck)){
                    array_push($modelArr, $value);
                    array_push($nameArrCheck, $value->nama);
                }
            }
        }
        $modelArr = collect((object) $modelArr);
        $modelArr = $modelArr->sortBy('path');
        $datatables = DataTables::of($modelArr)
        ->addColumn('jabatan', function($modelArr){
            $char = $modelArr->level * $modelArr->level * 4;
            $charRes = $char . 'px';
           return "<span style='padding-left:$charRes'>$modelArr->nama</span>";
        })
        ->addColumn('nip', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->nip;
            } else {
                return "-";
            }
        })
        ->addColumn('nama', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->nama;
            } else {
                return "-";
            }
        })
        ->addColumn('golongan', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->Golongan->nama;
            } else {
                return "-";
            }
        })
        ->addColumn('action', function($modelArr){
            $route = 'pemangku';
            $data = $modelArr;
            return view('layouts.includes.table-action-pemangku',compact('data','route'));
        })
        ->rawColumns(['jabatan']);
        return $datatables->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = $this->title;
        $route = $this->routeName;
        $datas =  UptDaerah::pluck('nama_daerah', 'id');
        $year = date('Y');
        return view('target.create', compact('title', 'route', 'datas', 'year'));
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
        try{
            DB::beginTransaction();
            $Pemangku = Pemangku::create($request->all());
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Data Pemangku"
            ]);
            DB::commit();
            return redirect($this->routeName)->with(['success'=>'Berhasil Menambah Data Pemangku: '.$Pemangku->id]);
        } catch (Throwable $th){
            DB::rollback();
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Pemangku : '.$th->getMessage()])->withErrors($request->all());
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
        $datas = Target::select("*")->where("id", "=", $id)->get();
        $title = $this->title;
        $route = $this->routeName;
        $year = date('Y');
        $daerahs = UptDaerah::pluck('nama_daerah', 'id');
        return view('target.edit', compact('datas', 'title', 'route', 'year', 'daerahs'));
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
       
        $unitKerja = UnitKerja::findOrFail($id);
        DB::beginTransaction();
        try{
            $dokterSpesialis = DokterSpesialis::where('unit_kerja_id', $id)->first();
            $dokter = Dokter::where('unit_kerja_id', $id)->first();
            $dokterGigi = DokterGigi::where('unit_kerja_id', $id)->first();
            $dokterGigiSpesialis = DokterGigiSpesialis::where('unit_kerja_id', $id)->first();

            $dokterSpesialis->update([
                'laki_laki' => $request->dokter_spesialis_laki_laki,
                'perempuan' => $request->dokter_spesialis_perempuan,
            ]);
            $dokter->update([
                'laki_laki' => $request->dokter_laki_laki,
                'perempuan' => $request->dokter_perempuan,
            ]);
            $dokterGigi->update([
                'laki_laki' => $request->dokter_gigi_laki_laki,
                'perempuan' => $request->dokter_gigi_perempuan,
            ]);
            $dokterGigiSpesialis->update([
                'laki_laki' => $request->dokter_gigi_spesialis_laki_laki,
                'perempuan' => $request->dokter_gigi_spesialis_perempuan,
            ]);

            DB::commit();
            return redirect($this->routeName)->with(['success'=>'Berhasil Mengubah data']);
        } catch(Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Pemangku : '.$e->getMessage()])->withErrors($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
         try{
            $query = Pemangku::findOrFail($id);
            $query->delete();
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Pemangku"
            ]);
            return redirect($this->routeName)->with(['success'=>'Berhasil Menghapus Pemangku : '.$query->nama]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Pemangku : '.$e->getMessage()])->withErrors($request->all());
        }
    }
    
    public function api($id){

       $unitKerja = UnitKerja::where('id', $id)->first();
       $dokterSpesialis = DokterSpesialis::where('unit_kerja_id', $id)->first();
       $dokter = Dokter::where('unit_kerja_id', $id)->first();
       $dokterGigi = DokterGigi::where('unit_kerja_id', $id)->first();
       $dokterGigiSpesialis = DokterGigiSpesialis::where('unit_kerja_id', $id)->first();
        if($unitKerja){
            return response()->json([
                'status' => 'success',
                'data' => $unitKerja,
                'dokterSpesialis' => $dokterSpesialis,
                'dokter' => $dokter,
                'dokterGigi' => $dokterGigi,
                'dokterGigiSpesialis' => $dokterGigiSpesialis,
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'data' => "Kesalahan terjadi saat mengambil data"
            ]);
        }
    }
}
