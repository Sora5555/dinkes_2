<?php

namespace App\Http\Controllers;

use App\Exports\KegiatanExport;
use App\Models\Desa;
use App\Models\Program;
use App\Models\IndukOpd;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\detailKegiatan;
use App\Models\Manajemen;
use App\Models\PejabatStruktural;
use App\Models\TenagaPendidik;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'kegiatan';
    protected $viewName = 'kegiatan';
    protected $title = 'Kegiatan';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $induk_opd_arr = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->whereYear('created_at', Session::get('year'))->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();
        }
        return view('kegiatan.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));
    }

    public function datatable(Request $request){
        $datas = Kegiatan::where('program_id', $request->program_id)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'kegiatan';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaranKegiatan';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikatorKegiatan';
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
            $Kegiatan = Kegiatan::create($request->all());

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Kegiatan : '.$Kegiatan->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
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

                // <td>{{$item->PejabatStruktural->sum("laki_laki")}}</td>
                // <td>{{$item->PejabatStruktural->sum("perempuan")}}</td>
                // <td>{{$item->PejabatStruktural->sum("laki_laki") + $item->PejabatStruktural->sum("perempuan")}}</td>\

                // <td>{{$item->TenagaPendidik->sum("laki_laki")}}</td>
                // <td>{{$item->TenagaPendidik->sum("perempuan")}}</td>
                // <td>{{$item->TenagaPendidik->sum("laki_laki") + $item->TenagaPendidik->sum("perempuan")}}</td>

                // <td>{{$item->Manajemen->sum("laki_laki")}}</td>
                // <td>{{$item->Manajemen->sum("perempuan")}}</td>
                // <td>{{$item->Manajemen->sum("laki_laki") + $item->Manajemen->sum("perempuan")}}</td>

                $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

                if($unit_kerja) {
                    $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                    if($desa) {
                        $PejabatStrukturalExist = PejabatStruktural::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($PejabatStrukturalExist) {
                            $PejabatStrukturalUpdate = PejabatStruktural::find($PejabatStrukturalExist->id);
                            $PejabatStrukturalUpdate->laki_laki = $row[3];
                            $PejabatStrukturalUpdate->perempuan = $row[4];
                            $PejabatStrukturalUpdate->save();
                        } else {
                            $PejabatStrukturalAdd = new PejabatStruktural;
                            $PejabatStrukturalAdd->unit_kerja_id = $unit_kerja->id;
                            $PejabatStrukturalAdd->desa_id = $desa->id;
                            $PejabatStrukturalAdd->laki_laki = $row[3];
                            $PejabatStrukturalAdd->perempuan = $row[4];
                            $PejabatStrukturalAdd->save();
                        }


                        $TenagaPendidikExist = TenagaPendidik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($TenagaPendidikExist) {
                            $TenagaPendidikUpdate = TenagaPendidik::find($TenagaPendidikExist->id);
                            $TenagaPendidikUpdate->laki_laki = $row[6];
                            $TenagaPendidikUpdate->perempuan = $row[7];
                            $TenagaPendidikUpdate->save();
                        } else {
                            $TenagaPendidikAdd = new TenagaPendidik;
                            $TenagaPendidikAdd->unit_kerja_id = $unit_kerja->id;
                            $TenagaPendidikAdd->desa_id = $desa->id;
                            $TenagaPendidikAdd->laki_laki = $row[6];
                            $TenagaPendidikAdd->perempuan = $row[7];
                            $TenagaPendidikAdd->save();
                        }

                        $ManajemenExist = Manajemen::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($ManajemenExist) {
                            $ManajemenUpdate = Manajemen::find($ManajemenExist->id);
                            $ManajemenUpdate->laki_laki = $row[9];
                            $ManajemenUpdate->perempuan = $row[10];
                            $ManajemenUpdate->save();
                        } else {
                            $ManajemenAdd = new Manajemen;
                            $ManajemenAdd->unit_kerja_id = $unit_kerja->id;
                            $ManajemenAdd->desa_id = $desa->id;
                            $ManajemenAdd->laki_laki = $row[9];
                            $ManajemenAdd->perempuan = $row[10];
                            $ManajemenAdd->save();
                        }

                        // $KeteknisanMedikExist = KeteknisanMedik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        // if($KeteknisanMedikExist) {
                        //     $KeteknisanMedikUpdate = KeteknisanMedik::find($KeteknisanMedikExist->id);
                        //     $KeteknisanMedikUpdate->laki_laki = $row[12];
                        //     $KeteknisanMedikUpdate->perempuan = $row[13];
                        //     $KeteknisanMedikUpdate->save();
                        // } else {
                        //     $KeteknisanMedikAdd = new KeteknisanMedik;
                        //     $KeteknisanMedikAdd->unit_kerja_id = $unit_kerja->id;
                        //     $KeteknisanMedikAdd->desa_id = $desa->id;
                        //     $KeteknisanMedikAdd->laki_laki = $row[12];
                        //     $KeteknisanMedikAdd->perempuan = $row[13];
                        //     $KeteknisanMedikAdd->save();
                        // }
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

    public function export() {
        try {
            return Excel::download(new KegiatanExport, 'kegiatan_report_'.Session::get('year').'.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
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
        $desa = Desa::with('PejabatStruktural', 'TenagaPendidik', 'Manajemen')->where('unit_kerja_id',$id)->get();

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
    //    dd($request->all());
       $unitKerja = UnitKerja::where('id', $id)->first();
       $pejabatStruktural = PejabatStruktural::where('unit_kerja_id', $id)->first();
       $tenagaPendidik = TenagaPendidik::where('unit_kerja_id', $id)->first();
       $pendukungManajemen = Manajemen::where('unit_kerja_id', $id)->first();
        try {
            $pejabatStruktural->update([
                'laki_laki' => $request->pejabatStrukturalLakiLaki,
                'perempuan' => $request->pejabatStrukturalPerempuan,
            ]);
            $tenagaPendidik->update([
                'laki_laki' => $request->tenagaPendidikLakiLaki,
                'perempuan' => $request->tenagaPendidikPerempuan,
            ]);
            $pendukungManajemen->update([
                'laki_laki' => $request->pendukungManajemenLakiLaki,
                'perempuan' => $request->pendukungManajemenPerempuan,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil mengubah Data']);
            //code...
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
        $kegiatan = Kegiatan::find($id);
        $detailKegiatan = detailKegiatan::where('kegiatan_id', $id)->first();

        try {
            if($detailKegiatan){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Kegiatan Masih Memiliki data rincian']);
            }
            $kegiatan->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil menghapus Data Kegiatan : '.$kegiatan->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function apiProgram($id){

        $program = Program::where('induk_opd_id', $id)->get();

        return response()->json([
            'status' => 'success',
            'data' => $program,
        ]);
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
        $pejabatStruktural = PejabatStruktural::where('unit_kerja_id', $id)->first();
        $tenagaPendidik = TenagaPendidik::where('unit_kerja_id', $id)->first();
        $pendukungManajemen = Manajemen::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'pejabatStruktural' => $pejabatStruktural,
            'tenagaPendidik' => $tenagaPendidik,
            'pendukungManajemen' => $pendukungManajemen,
        ]);
    }
}
