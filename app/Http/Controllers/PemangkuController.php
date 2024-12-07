<?php

namespace App\Http\Controllers;

use App\Models\Desa;
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
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
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
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->whereYear('created_at', Session::get('year'))->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();
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

    public function import(Request $request)
{
    $file = $request->file('excel_file');
    function check_internet_connection() {
        return @fsockopen("www.google.com", 80); // Open a connection to google.com on port 80 (HTTP) - Change the domain if needed
    }
    // dd($request->all());

    $data = Excel::toArray([], $file, null, \Maatwebsite\Excel\Excel::XLSX)[0];
    DB::BeginTransaction();
    foreach ($data as $key => $row) {
        if($key == 0 || $key == 1){
            continue;
        } else {
            // dd($row);
            // <td>{{$item->DokterSpesialis->sum("laki_laki")}}</td>
            // <td>{{$item->DokterSpesialis->sum("perempuan")}}</td>
            // <td>{{$item->DokterSpesialis->sum("laki_laki") + $item->DokterSpesialis->sum("laki_laki")}}</td>

            // <td>{{$item->Dokter->sum("laki_laki")}}</td>
            // <td>{{$item->Dokter->sum("perempuan")}}</td>
            // <td>{{$item->Dokter->sum("laki_laki") + $item->Dokter->sum("perempuan")}}</td>

            // <td>{{$item->DokterGigi->sum("laki_laki")}}</td>
            // <td>{{$item->DokterGigi->sum("perempuan")}}</td>
            // <td>{{$item->DokterGigi->sum("laki_laki") + $item->DokterGigi->sum("perempuan")}}</td>

            // <td>{{$item->DokterGigiSpesialis->sum("laki_laki")}}</td>
            // <td>{{$item->DokterGigiSpesialis->sum("perempuan")}}</td>
            // <td>{{$item->DokterGigiSpesialis->sum("laki_laki") + $item->DokterGigiSpesialis->sum("perempuan")}}</td>

            $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

            if($unit_kerja) {
                $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                if($desa) {
                    $DokterSpesialisExist = DokterSpesialis::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($DokterSpesialisExist) {
                        $DokterSpesialisUpdate = DokterSpesialis::find($DokterSpesialisExist->id);
                        $DokterSpesialisUpdate->laki_laki = $row[3];
                        $DokterSpesialisUpdate->perempuan = $row[4];
                        $DokterSpesialisUpdate->save();
                    } else {
                        $DokterSpesialisAdd = new DokterSpesialis;
                        $DokterSpesialisAdd->unit_kerja_id = $unit_kerja->id;
                        $DokterSpesialisAdd->desa_id = $desa->id;
                        $DokterSpesialisAdd->laki_laki = $row[3];
                        $DokterSpesialisAdd->perempuan = $row[4];
                        $DokterSpesialisAdd->save();
                    }


                    $DokterExist = Dokter::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($DokterExist) {
                        $DokterUpdate = Dokter::find($DokterExist->id);
                        $DokterUpdate->laki_laki = $row[6];
                        $DokterUpdate->perempuan = $row[7];
                        $DokterUpdate->save();
                    } else {
                        $DokterAdd = new Dokter;
                        $DokterAdd->unit_kerja_id = $unit_kerja->id;
                        $DokterAdd->desa_id = $desa->id;
                        $DokterAdd->laki_laki = $row[6];
                        $DokterAdd->perempuan = $row[7];
                        $DokterAdd->save();
                    }

                    $DokterGigiExist = DokterGigi::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($DokterGigiExist) {
                        $DokterGigiUpdate = DokterGigi::find($DokterGigiExist->id);
                        $DokterGigiUpdate->laki_laki = $row[9];
                        $DokterGigiUpdate->perempuan = $row[10];
                        $DokterGigiUpdate->save();
                    } else {
                        $DokterGigiAdd = new DokterGigi;
                        $DokterGigiAdd->unit_kerja_id = $unit_kerja->id;
                        $DokterGigiAdd->desa_id = $desa->id;
                        $DokterGigiAdd->laki_laki = $row[9];
                        $DokterGigiAdd->perempuan = $row[10];
                        $DokterGigiAdd->save();
                    }

                    $DokterGigiSpesialisExist = DokterGigiSpesialis::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($DokterGigiSpesialisExist) {
                        $DokterGigiSpesialisUpdate = DokterGigiSpesialis::find($DokterGigiSpesialisExist->id);
                        $DokterGigiSpesialisUpdate->laki_laki = $row[12];
                        $DokterGigiSpesialisUpdate->perempuan = $row[13];
                        $DokterGigiSpesialisUpdate->save();
                    } else {
                        $DokterGigiSpesialisAdd = new DokterGigiSpesialis;
                        $DokterGigiSpesialisAdd->unit_kerja_id = $unit_kerja->id;
                        $DokterGigiSpesialisAdd->desa_id = $desa->id;
                        $DokterGigiSpesialisAdd->laki_laki = $row[12];
                        $DokterGigiSpesialisAdd->perempuan = $row[13];
                        $DokterGigiSpesialisAdd->save();
                    }
                }

            }

            // $AhliLabMedikExist = AhliLabMedik


            // $sasaran_backup = SasaranTahunIbuHamil::where('desa_id', $desa->id)->first();

            // setlocale(LC_TIME, 'id_ID');
            // $timestamp = Carbon::now()->format('F');
            // if($sasaran_backup){
            //     $array_backup = $sasaran_backup->toArray();
            //     $array_backup_fix = collect($array_backup)->except(['created_at', 'updated_at', 'deleted_at'])->toArray();
            //     // dd($array_backup_fix);
            //     BackupSasaranTahunIbuHamil::create($array_backup_fix);
            //     $sasaran_backup->update([
            //         "sasaran_jumlah_ibu_hamil" => $row[2],
            //         'sasaran_april' => 0,
            //         'status_april' => 0,
            //         'capaian_april' => 0,
            //     ]);
            //     // if($key == 2){
            //     //     dd($monthNames[$timestamp], $sasaran_backup);
            //     // }
            // }
            setlocale(LC_TIME, 0);
        }
        if (!check_internet_connection()) {
            DB::rollBack(); // Rollback the transaction
            return redirect()->back()->with('error', 'Koneksi Hilang saat proses import data');
        }
    }
    DB::commit();

    return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Sasaran']);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $desa = Desa::with('DokterSpesialis', 'Dokter', 'DokterGigi' , 'DokterGigiSpesialis')->where('unit_kerja_id',$id)->get();

        return response()->json($desa);
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
