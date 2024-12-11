<?php

namespace App\Http\Controllers;

use App\Exports\SubKegiatanExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\Kegiatan;
use App\Models\UnitKerja;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use App\Models\detailSubKegiatan;
use App\Models\Posyandu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SubKegiatanController extends Controller
{
    protected $routeName = 'sub_kegiatan';
    protected $viewName = 'sub_kegiatan';
    protected $title = 'Sub Kegiatan';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $induk_opd_arr = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::get();
        }
        return view('sub_kegiatan.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));
    }

    public function datatable(Request $request){
        $datas = SubKegiatan::where('kegiatan_id', $request->kegiatan_id)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'sub_kegiatan';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaran_sub_kegiatan';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikator_sub_kegiatan';
            return view('layouts.includes.program-indikator',compact('data','route'));
        });
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
            $subKegiatan = SubKegiatan::create([
                'kode' => $request->kode,
                'kegiatan_id' => $request->kegiatan_id,
                'uraian' => $request->uraian,
                'induk_opd_id' => $request->induk_opd_id,
            ]);

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function export() {
        try {
            return Excel::download(new SubKegiatanExport, 'sub_kegiatan_report_'.Session::get('year').'.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
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

                // <td>${ item.Posyandu != null ? item.Posyandu.pratama : 0}</td>
                // <td>${parseFloat(pratamaPersent.toFixed(2))}%</td>
                // <td>${ item.Posyandu != null ? item.Posyandu.madya : 0}</td>
                // <td>${parseFloat(madyaPersent.toFixed(2))}%</td>
                // <td>${ item.Posyandu != null ? item.Posyandu.purnama : 0}</td>
                // <td>${parseFloat(purnamaPersent.toFixed(2))}%</td>
                // <td>${ item.Posyandu != null ? item.Posyandu.mandiri : 0}</td>
                // <td>${parseFloat(mandiriPersent.toFixed(2))}%</td>
                // <td>${PosyanduTotal}</td>
                // <td>${ item.Posyandu != null ? item.Posyandu.aktif : 0}</td>
                // <td>${parseFloat(aktifPersent.toFixed(2))}%</td>
                // <td>${ item.Posyandu != null ? item.Posyandu.posbindu : 0}</td>

                $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

                if($unit_kerja) {
                    $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                    if($desa) {
                        $PosyanduExist = Posyandu::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($PosyanduExist) {
                            $PosyanduUpdate = Posyandu::find($PosyanduExist->id);
                            $PosyanduUpdate->pratama = $row[3];
                            $PosyanduUpdate->madya = $row[4];
                            $PosyanduUpdate->purnama = $row[5];
                            $PosyanduUpdate->mandiri = $row[6];
                            $PosyanduUpdate->aktif = $row[7];
                            $PosyanduUpdate->posbindu = $row[8];
                            $PosyanduUpdate->save();
                        } else {
                            $PosyanduAdd = new Posyandu;
                            $PosyanduAdd->unit_kerja_id = $unit_kerja->id;
                            $PosyanduAdd->desa_id = $desa->id;
                            $PosyanduAdd->pratama = $row[3];
                            $PosyanduAdd->madya = $row[4];
                            $PosyanduAdd->purnama = $row[5];
                            $PosyanduAdd->mandiri = $row[6];
                            $PosyanduAdd->aktif = $row[7];
                            $PosyanduAdd->posbindu = $row[8];
                            $PosyanduAdd->save();
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
        //
        $desa = Desa::with('Posyandu')->where('unit_kerja_id',$id)->get();

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
           $unitKerja = UnitKerja::where("id", $id)->first();
           $posyandu = Posyandu::where('unit_kerja_id', $id)->first();
           $posyandu->update([
            'pratama' => $request->pratama,
            'madya' => $request->madya,
            'purnama' => $request->purnama,
            'mandiri' => $request->mandiri,
            'aktif' => $request->aktif,
            'posbindu' => $request->posbindu,
           ]);
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil Mengubah Data']);
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
            $detailSubKegiatan = detailSubKegiatan::where("sub_kegiatan_id", $id)->first();
            $subKegiatan = SubKegiatan::find($id);
            if($detailSubKegiatan){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Sub Kegiatan Masih Memiliki data Rincian']);
            }
            $subKegiatan->delete();

            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menghapus Data Sub Kegiatan']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiKegiatan($id){

        $kegiatan = Kegiatan::where('program_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $kegiatan,
        ]);
    }

    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
        $posyandu = Posyandu::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'posyandu' => $posyandu,
        ]);
    }
}
