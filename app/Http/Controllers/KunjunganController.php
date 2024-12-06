<?php

namespace App\Http\Controllers;

use App\Exports\KunjunganExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\Kunjungan;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'kunjungan';
    protected $viewName = 'kunjungan';
    protected $title = 'kunjungan';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Kunjungan::create([
        //         'desa_id' => $value->id,
        //         'unit_kerja_id' => 0,
        //         'jalan_L' => 1,
        //         'jalan_P' => 1,
        //         'inap_L' => 1,
        //         'inap_P' => 1,
        //         'jiwa_L' => 1,
        //         'jiwa_P' => 1,
        //     ]);
        // }
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
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            // $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
            // $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
            // $totalk4 += $desa->filterDesa(Session::get('year'))->k4;
            // $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
            // $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
            // $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
            // $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
            // $totalvita += $desa->filterDesa(Session::get('year'))->vita;
            // $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
        }
    } else{
        foreach($unit_kerja as $desa){
            $total += $desa->jumlah_ibu_hamil(Session::get('year'));
            $totalk1 += $desa->k1(Session::get('year'));
            $totalk4 += $desa->k4(Session::get('year'));
            $totalk6 += $desa->k6(Session::get('year'));
            $totalfasyankes += $desa->fasyankes(Session::get('year'));
            $totalkf1 += $desa->kf1(Session::get('year'));
            $totalkf_lengkap += $desa->kf_lengkap(Session::get('year'));
            $totalvita += $desa->vita(Session::get('year'));
            $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
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
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.index')->with($data);
}
public function add(Request $request)
{
    $counter = 0;

    $fillable = (new Kunjungan())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterKunjungan(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Kunjungan::create($data);
            $counter++;
        }
    }
    return redirect()->route($this->routeName . '.index')->with(['success' => 'Berhasil!']);
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
            $kunjungan = Kunjungan::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $kunjungan->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $jalan = (int)$kunjungan->jalan_L + (int)$kunjungan->jalan_P;
            $inap = (int)$kunjungan->inap_L + (int)$kunjungan->inap_P;
            $jiwa = (int)$kunjungan->jiwa_L + (int)$kunjungan->jiwa_P;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
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
                'jalan' => $jalan,
                'inap' => $inap,
                'jiwa' => $jiwa,
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
    public function report(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Kunjungan::create([
        //         'desa_id' => $value->id,
        //         'unit_kerja_id' => 0,
        //         'jalan_L' => 1,
        //         'jalan_P' => 1,
        //         'inap_L' => 1,
        //         'inap_P' => 1,
        //         'jiwa_L' => 1,
        //         'jiwa_P' => 1,
        //     ]);
        // }
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
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            // $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
            // $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
            // $totalk4 += $desa->filterDesa(Session::get('year'))->k4;
            // $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
            // $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
            // $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
            // $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
            // $totalvita += $desa->filterDesa(Session::get('year'))->vita;
            // $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
        }
    } else{
        foreach($unit_kerja as $desa){
            $total += $desa->jumlah_ibu_hamil(Session::get('year'));
            $totalk1 += $desa->k1(Session::get('year'));
            $totalk4 += $desa->k4(Session::get('year'));
            $totalk6 += $desa->k6(Session::get('year'));
            $totalfasyankes += $desa->fasyankes(Session::get('year'));
            $totalkf1 += $desa->kf1(Session::get('year'));
            $totalkf_lengkap += $desa->kf_lengkap(Session::get('year'));
            $totalvita += $desa->vita(Session::get('year'));
            $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
        }
    }
    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Kunjungan")->first();
    $nama_pengelola = "";
    $nip_pengelola = "";
    if($pengelola_program){
        $nama_pengelola = $pengelola_program->nama;
        $nip_pengelola = $pengelola_program->nip;
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
        'nama_pengelola' => $nama_pengelola,
        'nip_pengelola' => $nip_pengelola,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.report')->with($data);
}
    public function apiLock(Request $request){

        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->KunjunganLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new KunjunganExport, 'Kunjungan_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
