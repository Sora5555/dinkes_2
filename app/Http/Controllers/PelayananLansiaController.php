<?php

namespace App\Http\Controllers;

use App\Exports\PelayananLansiaExport;
use App\Exports\PelayananProduktifExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\PelayananLansia;
use App\Models\PengelolaProgram;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PelayananLansiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'pelayanan_lansia';
    protected $viewName = 'pelayanan_lansia';
    protected $title = 'pelayanan_lansia';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     PelayananLansia::create([
        //         'desa_id' => $value->id,
        //         'jumlah_L' => 0,
        //         'jumlah_P' => 0,
        //         'standar_L' => 0,
        //         'standar_P' => 0,
        //         'risiko_L' => 0,
        //         'risiko_P' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_L = 0;
    $total_P = 0;
    $totalstandar_L = 0;
    $totalstandar_P = 0;
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
            if($desa->filterPelayananLansia(Session::get('year'))){
                $total_L += $desa->filterPelayananLansia(Session::get('year'))->jumlah_L;
                $total_P += $desa->filterPelayananLansia(Session::get('year'))->jumlah_P;
                $totalstandar_L += $desa->filterPelayananLansia(Session::get('year'))->standar_L;
                $totalstandar_P += $desa->filterPelayananLansia(Session::get('year'))->standar_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_L += $desa->jumlah_lansia_L(Session::get('year'));
            $total_P += $desa->jumlah_lansia_P(Session::get('year'));
            $totalstandar_L += $desa->standar_lansia_L(Session::get('year'));
            $totalstandar_P += $desa->standar_lansia_P(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_L' => $total_L,
        'total_P' => $total_P,
        'totalstandar_L' => $totalstandar_L,
        'totalstandar_P' => $totalstandar_P,
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

    $fillable = (new PelayananLansia())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterPelayananLansia(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            PelayananLansia::create($data);
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
            $pelayanan_lansia = PelayananLansia::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $pelayanan_lansia->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $jumlah_LP = (int)$pelayanan_lansia->jumlah_L + $pelayanan_lansia->jumlah_P;
            $standar_LP = (int)$pelayanan_lansia->standar_L + $pelayanan_lansia->standar_P;
            $standar_L = (int)$pelayanan_lansia->standar_L/(int)$pelayanan_lansia->jumlah_L*100;
            $standar_P = (int)$pelayanan_lansia->standar_P/(int)$pelayanan_lansia->jumlah_P*100;
            $persen_standar_LP = ((int)$pelayanan_lansia->standar_L + (int)$pelayanan_lansia->standar_P)/((int)$pelayanan_lansia->jumlah_L + (int)$pelayanan_lansia->jumlah_P)*100;
            // $persen_balita_dipantau = (int)$kesehatan_balita->balita_dipantau/$kesehatan_balita->balita_0_59*100;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $pelayanan_lansia->Desa->UnitKerja;
            $total = 0;
            $total_LP = 0;
            $totalstandar_LP = 0;
            $total_L = 0;
            $total_P = 0;
            $totalstandar_L = 0;
            $totalstandar_P = 0;
            $percentage = 0;
            $percentage_totalstandar_LP = 0;
            $percent_standar_L = 0;
            $percent_standar_P = 0;


            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total+= $value->filterPelayananLansia(Session::get('year'))->{$request->name};
                $total_LP += $value->filterPelayananLansia(Session::get('year'))->jumlah_L + $value->filterPelayananLansia(Session::get('year'))->jumlah_P;
                $total_L += $value->filterPelayananLansia(Session::get('year'))->jumlah_L;
                $total_P += $value->filterPelayananLansia(Session::get('year'))->jumlah_P;
                $totalstandar_L += $value->filterPelayananLansia(Session::get('year'))->standar_L;
                $totalstandar_P += $value->filterPelayananLansia(Session::get('year'))->standar_P;
                $totalstandar_LP += $value->filterPelayananLansia(Session::get('year'))->standar_L + $value->filterPelayananLansia(Session::get('year'))->standar_P;
            }
            if(Str::contains($request->name, "_L")){
                $percentage = $total_L > 0?number_format($total/$total_L * 100, 2):0;
                $percent_standar_L = $total_L > 0?number_format($totalstandar_L/$total_L * 100, 2):0;
            } else {
                $percentage = $total_P > 0?number_format($total/$total_P * 100, 2):0;
                $percent_standar_P = $total_P > 0?number_format($totalstandar_P/$total_P * 100, 2):0;
            }
            $percentage_totalstandar_LP = $total_LP > 0?number_format($totalstandar_LP / $total_LP * 100, 2):0;

            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'jumlah_LP' => $jumlah_LP,
                'standar_L' => $standar_L,
                'standar_P' => $standar_P,
                'standar_LP' => $standar_LP,
                'persen_standar_LP' => $persen_standar_LP,
                'total' => $total,
                'column' => $request->name,
                'percentage' => $percentage,
                'percentage_totalstandar_LP' => $percentage_totalstandar_LP,
                'totalstandar_LP' => $totalstandar_LP,
                'total_LP' => $total_LP,
                'percent_standar_L' => $percent_standar_L,
                'percent_standar_P' => $percent_standar_P,
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
        //     PelayananLansia::create([
        //         'desa_id' => $value->id,
        //         'jumlah_L' => 0,
        //         'jumlah_P' => 0,
        //         'standar_L' => 0,
        //         'standar_P' => 0,
        //         'risiko_L' => 0,
        //         'risiko_P' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_L = 0;
    $total_P = 0;
    $totalstandar_L = 0;
    $totalstandar_P = 0;
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
            if($desa->filterPelayananLansia(Session::get('year'))){
                $total_L += $desa->filterPelayananLansia(Session::get('year'))->jumlah_L;
                $total_P += $desa->filterPelayananLansia(Session::get('year'))->jumlah_P;
                $totalstandar_L += $desa->filterPelayananLansia(Session::get('year'))->standar_L;
                $totalstandar_P += $desa->filterPelayananLansia(Session::get('year'))->standar_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_L += $desa->jumlah_lansia_L(Session::get('year'));
            $total_P += $desa->jumlah_lansia_P(Session::get('year'));
            $totalstandar_L += $desa->standar_lansia_L(Session::get('year'));
            $totalstandar_P += $desa->standar_lansia_P(Session::get('year'));
        }
    }

    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Pelayanan Lansia")->first();
    $nama_pengelola = "";
    $nip_pengelola = "";
    if($pengelola_program){
        $nama_pengelola = $pengelola_program->nama;
        $nip_pengelola = $pengelola_program->nip;
    }
    if(Session::get('year')){
        $tahun = Session::get('year');
    } else {
        $tahun = Carbon::now()->format('Y');
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_L' => $total_L,
        'total_P' => $total_P,
        'totalstandar_L' => $totalstandar_L,
        'totalstandar_P' => $totalstandar_P,
        'total_fasyankes' => $totalfasyankes,
        'total_kf1' => $totalkf1,
        'total_kf_lengkap' => $totalkf_lengkap,
        'total_vita' => $totalvita,
        'total_ibu_bersalin' => $totalibubersalin,
        'nama_pengelola' => $nama_pengelola,
        'nip_pengelola' => $nip_pengelola,
        'tahun' => $tahun,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.report')->with($data);
}
    public function apiLock(Request $request){

        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->PelayananLansiaLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new PelayananLansiaExport, 'pelayanan_Lansia_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
