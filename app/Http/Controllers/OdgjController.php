<?php

namespace App\Http\Controllers;

use App\Exports\OdgjExport;
use App\Models\Desa;
use App\Models\Odgj;
use App\Models\IndukOpd;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class OdgjController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'odgj';
    protected $viewName = 'odgj';
    protected $title = 'odgj';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Odgj::create([
        //         'desa_id' => $value->id,
        //         'skizo_0' => 1,
        //         'skizo_15' => 1,
        //         'skizo_60' => 1,
        //         'psiko_0' => 1,
        //         'psiko_15' => 1,
        //         'psiko_60' => 1,
        //         'sasaran' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_sasaran = 0;
    $total_skizo_0 = 0;
    $total_skizo_15 = 0;
    $total_skizo_60 = 0;
    $total_psiko_0 = 0;
    $total_psiko_15 = 0;
    $total_psiko_60 = 0;
    $total_jiwa_L = 0;
    $total_jiwa_P = 0;
    $totalvita = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterOdgj(Session::get('year'))){
                $total_sasaran += $desa->filterOdgj(Session::get('year'))->sasaran;
                $total_skizo_0 += $desa->filterOdgj(Session::get('year'))->skizo_0;
                $total_skizo_15 += $desa->filterOdgj(Session::get('year'))->skizo_15;
                $total_skizo_60 += $desa->filterOdgj(Session::get('year'))->skizo_60;
                $total_psiko_0 += $desa->filterOdgj(Session::get('year'))->psiko_0;
                $total_psiko_15 += $desa->filterOdgj(Session::get('year'))->psiko_15;
                $total_psiko_60 += $desa->filterOdgj(Session::get('year'))->psiko_60;
                $total_jiwa_L += $desa->filterKunjungan(Session::get('year'))->jiwa_L;
                $total_jiwa_P += $desa->filterKunjungan(Session::get('year'))->jiwa_P;

            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_sasaran += $desa->sasaran_odgj(Session::get('year'));
            $total_skizo_0 += $desa->skizo_0(Session::get('year'));
            $total_skizo_15 += $desa->skizo_15(Session::get('year'));
            $total_skizo_60 += $desa->skizo_60(Session::get('year'));
            $total_psiko_0 += $desa->psiko_0(Session::get('year'));
            $total_psiko_15 += $desa->psiko_15(Session::get('year'));
            $total_psiko_60 += $desa->psiko_60(Session::get('year'));
            $total_jiwa_L += $desa->jiwa_L(Session::get('year'));
            $total_jiwa_P += $desa->jiwa_P(Session::get('year'));
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
        'total_sasaran' => $total_sasaran,
        'total_skizo_0' => $total_skizo_0,
        'total_skizo_15' => $total_skizo_15,
        'total_skizo_60' => $total_skizo_60,
        'total_psiko_0' => $total_psiko_0,
        'total_psiko_15' => $total_psiko_15,
        'total_psiko_60' => $total_psiko_60,
        'total_jiwa_L' => $total_jiwa_L,
        'total_jiwa_P' => $total_jiwa_P,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.index')->with($data);
}
public function add(Request $request)
{
    $counter = 0;

    $fillable = (new Odgj())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterOdgj(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Odgj::create($data);
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
            $odgj = Odgj::where('id', $request->id)->first();
            $desa = $odgj->desa;
            $kunjungan = $desa->filterKunjungan(Session::get('year'));
            // dd($request->name, $request->value);
            $odgj->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $total_0 = (int)$odgj->skizo_0 + (int)$odgj->psiko_0;
            $total_15 = (int)$odgj->skizo_15 + (int)$odgj->psiko_15;
            $total_60 = (int)$odgj->skizo_60 + (int)$odgj->psiko_60;
            $persen = (int)($kunjungan->jiwa_L + (int)$kunjungan->jiwa_P)/$odgj->sasaran*100;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $odgj->Desa->UnitKerja;
            $total = 0;
            $jumlah_0 = 0;
            $jumlah_15 = 0;
            $jumlah_60 = 0;
            $jumlah_sasaran = 0;
            $jumlah_kunjungan = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total += $value->filterOdgj(Session::get('year'))->{$request->name};
                $jumlah_0 += $value->filterOdgj(Session::get('year'))->skizo_0 + $value->filterOdgj(Session::get('year'))->psiko_0;
                $jumlah_15 += $value->filterOdgj(Session::get('year'))->skizo_15 + $value->filterOdgj(Session::get('year'))->psiko_15;
                $jumlah_60 += $value->filterOdgj(Session::get('year'))->skizo_60 + $value->filterOdgj(Session::get('year'))->psiko_60;
                $jumlah_sasaran += $value->filterOdgj(Session::get('year'))->sasaran;
                $jumlah_kunjungan += $value->filterKunjungan(Session::get('year'))->jiwa_L + $value->filterKunjungan(Session::get('year'))->jiwa_P;
            }
            $percentage = $jumlah_sasaran>0?number_format($jumlah_kunjungan/$jumlah_sasaran*100, 2):0;
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'total_0' => $total_0,
                'total_15' => $total_15,
                'total_60' => $total_60,
                'persen' => $persen,
                'total' => $total,
                'column' => $request->name,
                'jumlah_0' => $jumlah_0,
                'jumlah_15' => $jumlah_15,
                'jumlah_60' => $jumlah_60,
                'percentage' => $percentage,
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
        //     Odgj::create([
        //         'desa_id' => $value->id,
        //         'skizo_0' => 1,
        //         'skizo_15' => 1,
        //         'skizo_60' => 1,
        //         'psiko_0' => 1,
        //         'psiko_15' => 1,
        //         'psiko_60' => 1,
        //         'sasaran' => 1,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_sasaran = 0;
    $total_skizo_0 = 0;
    $total_skizo_15 = 0;
    $total_skizo_60 = 0;
    $total_psiko_0 = 0;
    $total_psiko_15 = 0;
    $total_psiko_60 = 0;
    $total_jiwa_L = 0;
    $total_jiwa_P = 0;
    $totalvita = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterOdgj(Session::get('year'))){
                $total_sasaran += $desa->filterOdgj(Session::get('year'))->sasaran;
                $total_skizo_0 += $desa->filterOdgj(Session::get('year'))->skizo_0;
                $total_skizo_15 += $desa->filterOdgj(Session::get('year'))->skizo_15;
                $total_skizo_60 += $desa->filterOdgj(Session::get('year'))->skizo_60;
                $total_psiko_0 += $desa->filterOdgj(Session::get('year'))->psiko_0;
                $total_psiko_15 += $desa->filterOdgj(Session::get('year'))->psiko_15;
                $total_psiko_60 += $desa->filterOdgj(Session::get('year'))->psiko_60;
                $total_jiwa_L += $desa->filterKunjungan(Session::get('year'))->jiwa_L;
                $total_jiwa_P += $desa->filterKunjungan(Session::get('year'))->jiwa_P;

            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_sasaran += $desa->sasaran_odgj(Session::get('year'));
            $total_skizo_0 += $desa->skizo_0(Session::get('year'));
            $total_skizo_15 += $desa->skizo_15(Session::get('year'));
            $total_skizo_60 += $desa->skizo_60(Session::get('year'));
            $total_psiko_0 += $desa->psiko_0(Session::get('year'));
            $total_psiko_15 += $desa->psiko_15(Session::get('year'));
            $total_psiko_60 += $desa->psiko_60(Session::get('year'));
            $total_jiwa_L += $desa->jiwa_L(Session::get('year'));
            $total_jiwa_P += $desa->jiwa_P(Session::get('year'));
            $totalvita += $desa->vita(Session::get('year'));
            $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
        }
    }
    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Orang Dalam Gangguan Jiwa")->first();
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
        'total_sasaran' => $total_sasaran,
        'total_skizo_0' => $total_skizo_0,
        'total_skizo_15' => $total_skizo_15,
        'total_skizo_60' => $total_skizo_60,
        'total_psiko_0' => $total_psiko_0,
        'total_psiko_15' => $total_psiko_15,
        'total_psiko_60' => $total_psiko_60,
        'total_jiwa_L' => $total_jiwa_L,
        'total_jiwa_P' => $total_jiwa_P,
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
        $unitKerja->OdgjLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new OdgjExport, 'Orang dalam gangguan jiwa_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
