<?php

namespace App\Http\Controllers;

use App\Exports\ProgramExport;
use App\Models\Apoteker;
use App\Models\Desa;
use App\Models\Program;
use App\Models\IndukOpd;
use App\Models\hariLibur;
use Illuminate\Http\Request;
use App\Models\detailProgram;
use App\Models\TenagaTeknisFarmasi;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Contracts\DataTable;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'program';
    protected $viewName = 'program';
    protected $title = 'Program';

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
        return view('program.index',compact('route','title', 'induk_opd_arr', 'unit_kerja'));

    }

    public function datatable(Request $request){
        $datas = Program::where('induk_opd_id', $request->induk_opd)->get();

        $datatables = DataTables::of($datas)->
        addIndexColumn()->
        addColumn('kode', function($data){
            return $data->full_kode;
        })->addColumn('nama', function($data){
            $route = 'program';
            return view('layouts.includes.program-nama',compact('data','route'));
        })->addColumn('sasaran', function($data){
            $route = 'sasaranProgram';
            return view('layouts.includes.program-sasaran',compact('data','route'));
        })->addColumn('indikator', function($data){
            $route = 'indikatorProgram';
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
        $route = $this->routeName;
        $title = $this->title;
        return view('hari_libur.create', compact('title', 'route'));
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
            $query = Program::create($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Program : '.$query->id]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function export() {
        try {
            return Excel::download(new ProgramExport, 'program_report_'.Session::get('year').'.xlsx');
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

                $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

                if($unit_kerja) {
                    $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                    if($desa) {
                        $TenagaTeknikFarmasiExist = TenagaTeknisFarmasi::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($TenagaTeknikFarmasiExist) {
                            $TenagaTeknikFarmasiUpdate = TenagaTeknisFarmasi::find($TenagaTeknikFarmasiExist->id);
                            $TenagaTeknikFarmasiUpdate->laki_laki = $row[3];
                            $TenagaTeknikFarmasiUpdate->perempuan = $row[4];
                            $TenagaTeknikFarmasiUpdate->save();
                        } else {
                            $TenagaTeknikFarmasiAdd = new TenagaTeknisFarmasi;
                            $TenagaTeknikFarmasiAdd->unit_kerja_id = $unit_kerja->id;
                            $TenagaTeknikFarmasiAdd->desa_id = $desa->id;
                            $TenagaTeknikFarmasiAdd->laki_laki = $row[3];
                            $TenagaTeknikFarmasiAdd->perempuan = $row[4];
                            $TenagaTeknikFarmasiAdd->save();
                        }

                        $ApotekerExist = Apoteker::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        if($ApotekerExist) {
                            $ApotekerUpdate = Apoteker::find($ApotekerExist->id);
                            $ApotekerUpdate->laki_laki = $row[6];
                            $ApotekerUpdate->perempuan = $row[7];
                            $ApotekerUpdate->save();
                        } else {
                            $ApotekerAdd = new Apoteker;
                            $ApotekerAdd->unit_kerja_id = $unit_kerja->id;
                            $ApotekerAdd->desa_id = $desa->id;
                            $ApotekerAdd->laki_laki = $row[6];
                            $ApotekerAdd->perempuan = $row[7];
                            $ApotekerAdd->save();
                        }


                        // $TenagaKesehatanLingkunganExist = TenagaKesehatanLingkungan::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        // if($TenagaKesehatanLingkunganExist) {
                        //     $TenagaKesehatanLingkunganUpdate = TenagaKesehatanLingkungan::find($TenagaKesehatanLingkunganExist->id);
                        //     $TenagaKesehatanLingkunganUpdate->laki_laki = $row[6];
                        //     $TenagaKesehatanLingkunganUpdate->perempuan = $row[7];
                        //     $TenagaKesehatanLingkunganUpdate->save();
                        // } else {
                        //     $TenagaKesehatanLingkunganAdd = new TenagaKesehatanLingkungan;
                        //     $TenagaKesehatanLingkunganAdd->unit_kerja_id = $unit_kerja->id;
                        //     $TenagaKesehatanLingkunganAdd->desa_id = $desa->id;
                        //     $TenagaKesehatanLingkunganAdd->laki_laki = $row[6];
                        //     $TenagaKesehatanLingkunganAdd->perempuan = $row[7];
                        //     $TenagaKesehatanLingkunganAdd->save();
                        // }

                        // $TenagaGiziExist = TenagaGizi::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                        // if($TenagaGiziExist) {
                        //     $TenagaGiziUpdate = TenagaGizi::find($TenagaGiziExist->id);
                        //     $TenagaGiziUpdate->laki_laki = $row[9];
                        //     $TenagaGiziUpdate->perempuan = $row[10];
                        //     $TenagaGiziUpdate->save();
                        // } else {
                        //     $TenagaGiziAdd = new TenagaGizi;
                        //     $TenagaGiziAdd->unit_kerja_id = $unit_kerja->id;
                        //     $TenagaGiziAdd->desa_id = $desa->id;
                        //     $TenagaGiziAdd->laki_laki = $row[9];
                        //     $TenagaGiziAdd->perempuan = $row[10];
                        //     $TenagaGiziAdd->save();
                        // }

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
        $desa = Desa::with('Apoteker', 'TenagaTeknikFarmasi')->where('unit_kerja_id',$id)->get();

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
        $data = HariLibur::where('id', $id)->first();
        $route = $this->routeName;
        $title = $this->title;
        return view('hari_libur.edit', compact('title', 'route', 'data'));

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

        $unitKerja = UnitKerja::where('id', $id)->first();
        try {
            $teknisFarmasi = TenagaTeknisFarmasi::where('unit_kerja_id', $id)->first();
            $apoteker = Apoteker::where('unit_kerja_id', $id)->first();
            $teknisFarmasi->update([
                'laki_laki' => $request->teknisFarmasiLakiLaki,
                'perempuan' => $request->teknisFarmasiPerempuan,
            ]);
            $apoteker->update([
                'laki_laki' => $request->apotekerLakiLaki,
                'perempuan' => $request->apotekerPerempuan
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil mengubah Data Program']);
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
            $query = Program::find($id);
            $detailProgram = detailProgram::where('program_id', $id)->first();

            if($detailProgram){
                return redirect(route($this->routeName.'.index'))->with(['success'=>'Program Masih Memiliki data rincian']);
            }
            $query->delete();
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil menghapus Data Program']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function apiEdit($id){

       $unitKerja = UnitKerja::where('id', $id)->first();

       $teknisFarmasi = TenagaTeknisFarmasi::where('unit_kerja_id', $id)->first();
       $apoteker = Apoteker::where('unit_kerja_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'teknisFarmasi' => $teknisFarmasi,
            'apoteker' => $apoteker,
        ]);
    }
}
