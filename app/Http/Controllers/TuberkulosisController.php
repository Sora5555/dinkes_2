<?php

namespace App\Http\Controllers;

use App\Exports\TuberkulosisExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\PengelolaProgram;
use App\Models\Tuberkulosis;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class TuberkulosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $routeName = 'tuberkulosis';
    protected $viewName = 'tuberkulosis';
    protected $title = 'tuberkulosis';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->tuberkulosis_per_desa(null)["kasus_anak"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Tuberkulosis::create([
        //         'desa_id' => $value->id,
        //         'unit_kerja_id' => 1,
        //         'terduga_kasus' => 1,
        //         'kasus_L' => 1,
        //         'kasus_P' => 1,
        //         'kasus_anak' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_terduga_kasus = 0;
    $total_kasus_L = 0;
    $total_kasus_P = 0;
    $total_kasus_LP = 0;
    $total_kasus_anak = 0;
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
            if($desa->filterTuberkulosis(Session::get('year'))){
                $total_terduga_kasus += $desa->filterTuberkulosis(Session::get('year'))->terduga_kasus;
                $total_kasus_L += $desa->filterTuberkulosis(Session::get('year'))->kasus_L;
                $total_kasus_P += $desa->filterTuberkulosis(Session::get('year'))->kasus_P;
                $total_kasus_LP += $desa->filterTuberkulosis(Session::get('year'))->kasus_LP;
                $total_kasus_anak += $desa->filterTuberkulosis(Session::get('year'))->kasus_anak;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_terduga_kasus += $desa->terduga_kasus(Session::get('year'));
            $total_kasus_L += $desa->kasus_L(Session::get('year'));
            $total_kasus_P += $desa->kasus_P(Session::get('year'));
            $total_kasus_LP += $desa->kasus_LP(Session::get('year'));
            $total_kasus_anak += $desa->kasus_anak(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_terduga_kasus' => $total_terduga_kasus,
        'total_kasus_L' => $total_kasus_L,
        'total_kasus_P' => $total_kasus_P,
        'total_kasus_LP' => $total_kasus_LP,
        'total_kasus_anak' => $total_kasus_anak,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.index')->with($data);
}
public function add(Request $request)
{
    $counter = 0;

    $fillable = (new Tuberkulosis())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterTuberkulosis(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Tuberkulosis::create($data);
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
            $tuberkulosis = Tuberkulosis::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $tuberkulosis->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $kasus_L = (int)$tuberkulosis->kasus_L / (int)$tuberkulosis->kasus_LP*100;
            $kasus_P = (int)$tuberkulosis->kasus_P / (int)$tuberkulosis->kasus_LP*100;
            // $persen_balita_dipantau = (int)$kesehatan_balita->balita_dipantau/$kesehatan_balita->balita_0_59*100;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $tuberkulosis->Desa->UnitKerja;
            $total = 0;
            $percentage = 0;
            $percentage_kasus_L = 0;
            $percentage_kasus_P = 0;
            $total_kasus_LP = 0;
            $total_kasus_L = 0;
            $total_kasus_P = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total += $value->filterTuberkulosis(Session::get('year'))->{$request->name};
                $total_kasus_LP += $value->filterTuberkulosis(Session::get('year'))->kasus_LP;
                $total_kasus_L += $value->filterTuberkulosis(Session::get('year'))->kasus_L;
                $total_kasus_P += $value->filterTuberkulosis(Session::get('year'))->kasus_P;
            }
            $percentage = $total_kasus_LP > 0?number_format($total/$total_kasus_LP*100, 2):0; 
            $percentage_kasus_L = $total_kasus_LP > 0?number_format($total_kasus_L/$total_kasus_LP*100, 2):0; 
            $percentage_kasus_P = $total_kasus_LP > 0?number_format($total_kasus_P/$total_kasus_LP*100, 2):0; 
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'kasus_L' => $kasus_L,
                'kasus_P' => $kasus_P,
                'total' => $total,
                'column' => $request->name,
                'percentage' => $percentage,
                'percentage_kasus_L' => $percentage_kasus_L,
                'percentage_kasus_P' => $percentage_kasus_P,
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
        // dd($unit_kerja1->tuberkulosis_per_desa(null)["kasus_anak"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Tuberkulosis::create([
        //         'desa_id' => $value->id,
        //         'unit_kerja_id' => 1,
        //         'terduga_kasus' => 1,
        //         'kasus_L' => 1,
        //         'kasus_P' => 1,
        //         'kasus_anak' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_terduga_kasus = 0;
    $total_kasus_L = 0;
    $total_kasus_P = 0;
    $total_kasus_LP = 0;
    $total_kasus_anak = 0;
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
            if($desa->filterTuberkulosis(Session::get('year'))){
                $total_terduga_kasus += $desa->filterTuberkulosis(Session::get('year'))->terduga_kasus;
                $total_kasus_L += $desa->filterTuberkulosis(Session::get('year'))->kasus_L;
                $total_kasus_P += $desa->filterTuberkulosis(Session::get('year'))->kasus_P;
                $total_kasus_LP += $desa->filterTuberkulosis(Session::get('year'))->kasus_LP;
                $total_kasus_anak += $desa->filterTuberkulosis(Session::get('year'))->kasus_anak;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_terduga_kasus += $desa->terduga_kasus(Session::get('year'));
            $total_kasus_L += $desa->kasus_L(Session::get('year'));
            $total_kasus_P += $desa->kasus_P(Session::get('year'));
            $total_kasus_LP += $desa->kasus_LP(Session::get('year'));
            $total_kasus_anak += $desa->kasus_anak(Session::get('year'));
        }
    }

    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Tuberkulosis")->first();
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
        'total_terduga_kasus' => $total_terduga_kasus,
        'total_kasus_L' => $total_kasus_L,
        'total_kasus_P' => $total_kasus_P,
        'total_kasus_LP' => $total_kasus_LP,
        'total_kasus_anak' => $total_kasus_anak,
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
        $unitKerja->TuberkulosisLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new TuberkulosisExport, 'Tuberkulosis_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
