<?php

namespace App\Http\Controllers;

use App\Exports\HipertensiExport;
use App\Models\Desa;
use App\Models\Hipertensi;
use App\Models\IndukOpd;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class HipertensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'hipertensi';
    protected $viewName = 'hipertensi';
    protected $title = 'hipertensi';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->tuberkulosis_per_desa(null)["kasus_anak"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Hipertensi::create([
        //         'desa_id' => $value->id,
        //         'jumlah_L' => 1,
        //         'jumlah_P' => 1,
        //         'pelayanan_L' => 1,
        //         'pelayanan_P' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_L = 0;
    $total_P = 0;
    $total_pelayanan_L = 0;
    $total_pelayanan_P = 0;
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
            if($desa->filterHipertensi(Session::get('year'))){
                $total_L += $desa->filterHipertensi(Session::get('year'))->jumlah_L;
                $total_P += $desa->filterHipertensi(Session::get('year'))->jumlah_P;
                $total_pelayanan_L += $desa->filterHipertensi(Session::get('year'))->pelayanan_L;
                $total_pelayanan_P += $desa->filterHipertensi(Session::get('year'))->pelayanan_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_L += $desa->jumlah_hipertensi_L(Session::get('year'));
            $total_P += $desa->jumlah_hipertensi_P(Session::get('year'));
            $total_pelayanan_L += $desa->pelayanan_hipertensi_L(Session::get('year'));
            $total_pelayanan_P += $desa->pelayanan_hipertensi_P(Session::get('year'));
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
        'total_pelayanan_L' => $total_pelayanan_L,
        'total_pelayanan_P' => $total_pelayanan_P,
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

    $fillable = (new Hipertensi())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterHipertensi(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Hipertensi::create($data);
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
            $hipertensi = Hipertensi::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $hipertensi->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $pelayanan_L = (int)$hipertensi->pelayanan_L / (int)$hipertensi->jumlah_L*100;
            $pelayanan_P = (int)$hipertensi->pelayanan_P / (int)$hipertensi->jumlah_P*100;
            $jumlah_LP = (int)$hipertensi->jumlah_P + (int)$hipertensi->jumlah_L;
            $pelayanan_LP = (int)$hipertensi->pelayanan_P + (int)$hipertensi->pelayanan_L;
            $persen_pelayanan_LP = ((int)$hipertensi->pelayanan_P + (int)$hipertensi->pelayanan_L)/((int)$hipertensi->jumlah_P + (int)$hipertensi->jumlah_L)*100;
            // $persen_balita_dipantau = (int)$kesehatan_balita->balita_dipantau/$kesehatan_balita->balita_0_59*100;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $hipertensi->Desa->UnitKerja;
            $total = 0;
            $total_L = 0;
            $total_P = 0;
            $total_pelayanan_L = 0;
            $total_pelayanan_P = 0;
            $percentage_pelayanan_LP = 0;
            $jumlah_pelayanan_LP = 0;
            $total_LP = 0;
            $percentage = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total += $value->filterHipertensi(Session::get('year'))->{$request->name};
                $total_L += $value->filterHipertensi(Session::get('year'))->jumlah_L;
                $total_P += $value->filterHipertensi(Session::get('year'))->jumlah_P;
                $total_pelayanan_L += $value->filterHipertensi(Session::get('year'))->pelayanan_L;
                $total_pelayanan_P += $value->filterHipertensi(Session::get('year'))->pelayanan_P;
            }
            $total_LP = $total_L + $total_P;
            $jumlah_pelayanan_LP = $total_pelayanan_L + $total_pelayanan_P;
            $percentage_pelayanan_LP = $total_LP > 0?number_format($jumlah_pelayanan_LP/$total_LP * 100, 2):0;
            $percentage_pelayanan_L = $total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0;
            $percentage_pelayanan_P = $total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0;
            if($request->name == "pelayanan_L"){
                $percentage = $total_L > 0?number_format($total_pelayanan_L/$total_L*100, 2):0;
            } else if($request->name == "pelayanan_P"){
                $percentage = $total_P > 0?number_format($total_pelayanan_P/$total_P*100, 2):0;
            }
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'pelayanan_L' => $pelayanan_L,
                'pelayanan_P' => $pelayanan_P,
                'pelayanan_LP' => $pelayanan_LP,
                'jumlah_LP' => $jumlah_LP,
                'persen_pelayanan_LP' => $persen_pelayanan_LP,
                'total' => $total,
                'percentage' => $percentage,
                'total_LP' => $total_LP,
                'jumlah_pelayanan_LP' => $jumlah_pelayanan_LP,
                'percentage_pelayanan_LP' => $percentage_pelayanan_LP,
                'percentage_pelayanan_L' => $percentage_pelayanan_L,
                'percentage_pelayanan_P' => $percentage_pelayanan_P,
                'column' => $request->name,
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
        //     Hipertensi::create([
        //         'desa_id' => $value->id,
        //         'jumlah_L' => 1,
        //         'jumlah_P' => 1,
        //         'pelayanan_L' => 1,
        //         'pelayanan_P' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_L = 0;
    $total_P = 0;
    $total_pelayanan_L = 0;
    $total_pelayanan_P = 0;
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
            if($desa->filterHipertensi(Session::get('year'))){
                $total_L += $desa->filterHipertensi(Session::get('year'))->jumlah_L;
                $total_P += $desa->filterHipertensi(Session::get('year'))->jumlah_P;
                $total_pelayanan_L += $desa->filterHipertensi(Session::get('year'))->pelayanan_L;
                $total_pelayanan_P += $desa->filterHipertensi(Session::get('year'))->pelayanan_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_L += $desa->jumlah_hipertensi_L(Session::get('year'));
            $total_P += $desa->jumlah_hipertensi_P(Session::get('year'));
            $total_pelayanan_L += $desa->pelayanan_hipertensi_L(Session::get('year'));
            $total_pelayanan_P += $desa->pelayanan_hipertensi_P(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Hipertensi")->first();
    $nama_pengelola = "";
    $nip_pengelola = "";
    if($pengelola_program){
        $nama_pengelola = $pengelola_program->nama;
        $nip_pengelola = $pengelola_program->nip;
    }

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_L' => $total_L,
        'total_P' => $total_P,
        'total_pelayanan_L' => $total_pelayanan_L,
        'total_pelayanan_P' => $total_pelayanan_P,
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
        $unitKerja->HipertensiLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new HipertensiExport, 'Hipertensi_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
