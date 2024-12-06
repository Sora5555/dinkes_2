<?php

namespace App\Http\Controllers;

use App\Models\BackupSasaranTahunIbuHamil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use App\Models\IbuHamilDanBersalin;
use App\Models\SasaranTahunIbuHamil;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use Illuminate\Support\Facades\DB;

class SasaranIbuHamilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'sasaran_ibu_hamil';
    protected $viewName = 'sasaran_ibu_hamil';
    protected $title = 'sasaran_ibu_hamil';
public function index(Request $request)
{
        //
    // Retrieve the data from the session
    $unit_kerja = UnitKerja::all();
    $total = 0;
    $totalk1 = 0;
    $totalk4 = 0;
    $totalk6 = 0;
    $totalfasyankes = 0;
    $totalkf1 = 0;
    $totalkf_lengkap = 0;
    $totalvita = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    foreach(Desa::all() as $desa){
            if($desa->filterDesa($request->query('year'))){
                $total += $desa->filterDesa($request->query('year'))->jumlah_ibu_hamil;
            $totalk1 += $desa->filterDesa($request->query('year'))->k1;
            $totalk4 += $desa->filterDesa($request->query('year'))->k4;
            $totalk6 += $desa->filterDesa($request->query('year'))->k6;
            $totalfasyankes += $desa->filterDesa($request->query('year'))->fasyankes;
            $totalkf1 += $desa->filterDesa($request->query('year'))->kf1;
            $totalkf_lengkap += $desa->filterDesa($request->query('year'))->kf_lengkap;
            $totalvita += $desa->filterDesa($request->query('year'))->vita;
            $totalibubersalin += $desa->filterDesa($request->query('year'))->jumlah_ibu_bersalin;
            }
        }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_ibu_hamil' => $total,
        'total_k1' => $totalk1,
        'total_k4' => $totalk4,
        'total_k6' => $totalk6,
        'total_fasyankes' => $totalfasyankes,
        'total_kf1' => $totalkf1,
        'total_kf_lengkap' => $totalkf_lengkap,
        'total_vita' => $totalvita,
        'total_ibu_bersalin' => $totalibubersalin,
        'current_month' => Carbon::now()->format('n')
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
        $sasaran_tahunan = SasaranTahunIbuHamil::where('id', $request->sasaran_id)->first();
        if($request->nilai_capaian > $sasaran_tahunan->sasaran_jumlah_ibu_hamil){
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Nilai yang dimasukkan melebih batas!']);    
        }
        $sasaran_tahunan->update([
            $request->bulan_capaian => $request->nilai_capaian,
        ]);
        if($sasaran_tahunan->{$request->status} == 0){
            $sasaran_tahunan->update([
                $request->status => 1,
            ]);
        } else if($sasaran_tahunan->{$request->status} == 2){
            $sasaran_tahunan->update([
                $request->status => 1,
            ]);
        }
        // dd($request->all(), $sasaran_tahunan->{$request->bulan_capaian});
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
    public function import(Request $request)
{
    $file = $request->file('excel_file');
    function check_internet_connection() {
        return @fsockopen("www.google.com", 80); // Open a connection to google.com on port 80 (HTTP) - Change the domain if needed
    }
    // dd($request->all());

    $data = FacadesExcel::toArray([], $file, null, \Maatwebsite\Excel\Excel::XLSX)[0];
    DB::BeginTransaction();
    foreach ($data as $key => $row) {
        if($key == 0){
            continue;
        } else {
            $desa = Desa::where('nama', $row[1])->first();
            if(!$desa->filterDesa($request->tahun)){
                IbuHamilDanBersalin::create([
                    "desa_id" => $desa->id,
                    "sasaran_jumlah_ibu_hamil" => 0,
                    "sasaran_jumlah_ibu_bersalin" => 0,
                    "jumlah_ibu_hamil" => 0,
                    "jumlah_ibu_bersalin" => 0,
                    "k1" => 0,
                    "k4" => 0,
                    "k6" => 0,
                    "fasyankes" => 0,
                    "kf1" => 0,
                    "kf_lengkap" => 0,
                    "vita" => 0,
                    "status" => 0,
                ]);
                SasaranTahunIbuHamil::create([
                    "sasaran_jumlah_ibu_hamil" => $row[2],
                    "desa_id" => $desa->id,
                    'sasaran_januari' => 0,
                    'capaian_januari' => 0,
                    'status_januari' => 0,
                    'sasaran_februari' => 0,
                    'capaian_februari' => 0,
                    'status_februari' => 0,
                ]);

            } else {
                $sasaran_backup = SasaranTahunIbuHamil::where('desa_id', $desa->id)->first();
                $monthNames = [
                    'January' => 'januari',
                    'February' => 'februari',
                    'March' => 'maret',
                    'April' => 'april',
                    'May' => 'mei',
                    'June' => 'juni',
                    'July' => 'juli',
                    'August' => 'agustus',
                    'September' => 'september',
                    'October' => 'oktober',
                    'November' => 'november',
                    'December' => 'desember',
                ];
                setlocale(LC_TIME, 'id_ID');
                $timestamp = Carbon::now()->format('F');
                if($sasaran_backup){
                    $array_backup = $sasaran_backup->toArray();
                    $array_backup_fix = collect($array_backup)->except(['created_at', 'updated_at', 'deleted_at'])->toArray();
                    // dd($array_backup_fix);
                    BackupSasaranTahunIbuHamil::create($array_backup_fix);
                    $sasaran_backup->update([
                        "sasaran_jumlah_ibu_hamil" => $row[2],
                        'sasaran_april' => 0,
                        'status_april' => 0,
                        'capaian_april' => 0,
                    ]);
                    // if($key == 2){
                    //     dd($monthNames[$timestamp], $sasaran_backup);
                    // }
                }
                setlocale(LC_TIME, 0);
            }
        }
        if (!check_internet_connection()) {
            DB::rollBack(); // Rollback the transaction
            return redirect()->back()->with('error', 'Koneksi Hilang saat proses import data');
        }
    }
    DB::commit();

    return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Sasaran']);
}
public function api($id){

    $sasaran = SasaranTahunIbuHamil::where('id', $id)->first();

    return response()->json([
        'status' => 'success',
        'data' => $sasaran,
    ]);
}
public function apiAcc(Request $request, $id){

    $sasaran = SasaranTahunIbuHamil::where('id', $id)->first();
    $sasaran->update([
        'status_'.$request->nama_bulan => 3
    ]);

    return response()->json([
        'status' => 'success',
        'data' => $request->all(),
    ]);
}
public function apiReject(Request $request, $id){

    $sasaran = SasaranTahunIbuHamil::where('id', $id)->first();
    $sasaran->update([
        'status_'.$request->nama_bulan => 2
    ]);

    return response()->json([
        'status' => 'success',
        'data' => $request->all(),
    ]);
}
public function apiCapaian(Request $request, $id){

    $sasaran = SasaranTahunIbuHamil::where('id', $id)->first();
    $sasaran->update([
        $request->name => $request->value,
    ]);
    $percent = number_format($sasaran->{$request->name}/$sasaran->{$request->bulan}*100, 2);
    return response()->json([
        'status' => 'success',
        'name' => $request->name,
        'percent' => $percent
    ]);
}
}
