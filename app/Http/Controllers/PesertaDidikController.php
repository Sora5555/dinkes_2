<?php

namespace App\Http\Controllers;

use App\Exports\PesertaDidikExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\PengelolaProgram;
use App\Models\PesertaDidik;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PesertaDidikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'peserta_didik';
    protected $viewName = 'peserta_didik';
    protected $title = 'peserta_didik';
    public function index(Request $request)
    {
    $unit_kerja = UnitKerja::all();
    $total_kelas_1 = 0;
    $total_pelayanan_kelas_1 = 0;
    $total_kelas_7 = 0;
    $total_pelayanan_kelas_7 = 0;
    $total_kelas_10 = 0;
    $total_pelayanan_kelas_10 = 0;
    $total_usia_dasar = 0;
    $total_pelayanan_usia_dasar = 0;
    $total_sd = 0;
    $total_pelayanan_sd = 0;
    $total_smp = 0;
    $total_pelayanan_smp = 0;
    $total_sma = 0;
    $total_pelayanan_sma = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterPesertaDidik(Session::get('year'))){
                $total_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1;
            $total_pelayanan_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1;
            $total_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7;
            $total_pelayanan_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7;
            $total_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10;
            $total_pelayanan_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10;
            $total_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar;
            $total_pelayanan_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar;
            $total_sd += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sd;
            $total_pelayanan_sd += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sd;
            $total_smp += $desa->filterPesertaDidik(Session::get('year'))->jumlah_smp;
            $total_pelayanan_smp += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_smp;
            $total_sma += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sma;
            $total_pelayanan_sma += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sma;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_kelas_1 += $desa->jumlah_kelas_1(Session::get('year'));
            $total_pelayanan_kelas_1 += $desa->pelayanan_kelas_1(Session::get('year'));
            $total_kelas_7 += $desa->jumlah_kelas_7(Session::get('year'));
            $total_pelayanan_kelas_7 += $desa->pelayanan_kelas_7(Session::get('year'));
            $total_kelas_10 +=$desa->jumlah_kelas_10(Session::get('year'));
            $total_pelayanan_kelas_10 += $desa->pelayanan_kelas_10(Session::get('year'));
            $total_usia_dasar += $desa->jumlah_usia_dasar(Session::get('year'));
            $total_pelayanan_usia_dasar += $desa->pelayanan_usia_dasar(Session::get('year'));
            $total_sd += $desa->jumlah_sd(Session::get('year'));
            $total_pelayanan_sd += $desa->pelayanan_sd(Session::get('year'));
            $total_smp += $desa->jumlah_smp(Session::get('year'));
            $total_pelayanan_smp += $desa->pelayanan_smp(Session::get('year'));
            $total_sma += $desa->jumlah_sma(Session::get('year'));
            $total_pelayanan_sma += $desa->pelayanan_sma(Session::get('year'));
        }
    }

    
    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_kelas_1' => $total_kelas_1,
        'total_pelayanan_kelas_1' => $total_pelayanan_kelas_1,
        'total_kelas_7' => $total_kelas_7,
        'total_pelayanan_kelas_7' => $total_pelayanan_kelas_7,
        'total_kelas_10' => $total_kelas_10,
        'total_pelayanan_kelas_10' => $total_pelayanan_kelas_10,
        'total_usia_dasar' => $total_usia_dasar,
        'total_pelayanan_usia_dasar' => $total_pelayanan_usia_dasar,
        'total_sd' => $total_sd,
        'total_pelayanan_sd' => $total_pelayanan_sd,
        'total_smp' => $total_smp,
        'total_pelayanan_smp' => $total_pelayanan_smp,
        'total_sma' => $total_sma,
        'total_pelayanan_sma' => $total_pelayanan_sma,
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

    $fillable = (new PesertaDidik())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterPesertaDidik(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            PesertaDidik::create($data);
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
            $peserta_didik = PesertaDidik::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $peserta_didik->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $persen_kelas_1 = (int)$peserta_didik->pelayanan_kelas_1/(int)$peserta_didik->jumlah_kelas_1*100;
            $persen_kelas_7 = (int)$peserta_didik->pelayanan_kelas_7/(int)$peserta_didik->jumlah_kelas_7*100;
            $persen_kelas_10 = (int)$peserta_didik->pelayanan_kelas_10/(int)$peserta_didik->jumlah_kelas_10*100;
            $persen_usia_dasar = (int)$peserta_didik->pelayanan_usia_dasar/(int)$peserta_didik->jumlah_usia_dasar*100;
            $persen_sd = (int)$peserta_didik->pelayanan_sd/(int)$peserta_didik->jumlah_sd*100;
            $persen_smp = (int)$peserta_didik->pelayanan_smp/(int)$peserta_didik->jumlah_smp*100;
            $persen_sma = (int)$peserta_didik->pelayanan_sma/(int)$peserta_didik->jumlah_sma*100;
            // $persen_balita_dipantau = (int)$kesehatan_balita->balita_dipantau/$kesehatan_balita->balita_0_59*100;
            // $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            // $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $peserta_didik->Desa->UnitKerja;
            $total = 0;
            $total_kelas_1 = 0;
            $total_pelayanan_kelas_1 = 0;
            $total_kelas_7 = 0;
            $total_pelayanan_kelas_7 = 0;
            $total_kelas_10 = 0;
            $total_pelayanan_kelas_10 = 0;
            $total_usia_dasar = 0;
            $total_pelayanan_usia_dasar = 0;
            $total_sd= 0;
            $total_pelayanan_sd = 0;
            $total_smp= 0;
            $total_pelayanan_smp = 0;
            $total_sma= 0;
            $total_pelayanan_sma = 0;
            $percentage = 0;
            $percentage_column = null;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total += $value->filterPesertaDidik(Session::get('year'))->{$request->name};
                $total_kelas_1 += $value->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1;
                $total_pelayanan_kelas_1 += $value->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1;
                $total_kelas_7 += $value->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7;
                $total_pelayanan_kelas_7 += $value->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7;
                $total_kelas_10 += $value->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10;
                $total_pelayanan_kelas_10 += $value->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10;
                $total_usia_dasar += $value->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar;
                $total_pelayanan_usia_dasar += $value->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar;
                $total_sd += $value->filterPesertaDidik(Session::get('year'))->jumlah_sd;
                $total_pelayanan_sd += $value->filterPesertaDidik(Session::get('year'))->pelayanan_sd;
                $total_smp += $value->filterPesertaDidik(Session::get('year'))->jumlah_smp;
                $total_pelayanan_smp += $value->filterPesertaDidik(Session::get('year'))->pelayanan_smp;
                $total_sma += $value->filterPesertaDidik(Session::get('year'))->jumlah_sma;
                $total_pelayanan_sma += $value->filterPesertaDidik(Session::get('year'))->pelayanan_sma;
            }
            if(preg_match('/\w*kelas_1(?=\D|$)/', $request->name)){
                $percentage = $total_kelas_1 > 0?number_format($total_pelayanan_kelas_1/$total_kelas_1 * 100, 2):0;
                $percentage_column = "kelas_1";

            } else if(Str::contains($request->name, 'kelas_7')){
                $percentage = $total_kelas_7 > 0?number_format($total_pelayanan_kelas_7/$total_kelas_7 * 100, 2):0;
                $percentage_column = "kelas_7";
            } else if(Str::contains($request->name, 'kelas_10')){
                $percentage = $total_kelas_10 > 0?number_format($total_pelayanan_kelas_10/$total_kelas_10 * 100, 2):0;
                $percentage_column = "kelas_10";
            } else if(Str::contains($request->name, 'usia_dasar')){
                $percentage = $total_usia_dasar > 0?number_format($total_pelayanan_usia_dasar/$total_usia_dasar * 100, 2):0;
                $percentage_column = "usia_dasar";
            } else if(Str::contains($request->name, 'sd')){
                $percentage = $total_sd > 0?number_format($total_pelayanan_sd/$total_sd * 100, 2):0;
                $percentage_column = "sd";
            } else if(Str::contains($request->name, 'smp')){
                $percentage = $total_smp > 0?number_format($total_pelayanan_smp/$total_smp * 100, 2):0;
                $percentage_column = "smp";
            } else if(Str::contains($request->name, 'sma')){
                $percentage = $total_sma > 0?number_format($total_pelayanan_sma/$total_sma * 100, 2):0;
                $percentage_column = "sma";
            }
            // dd($percentage, $total_kelas_1, $total_pelayanan_kelas_1);

            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'persen_kelas_1' => $persen_kelas_1,
                'persen_kelas_7' => $persen_kelas_7,
                'persen_kelas_10' => $persen_kelas_10,
                'persen_usia_dasar' => $persen_usia_dasar,
                'persen_sd' => $persen_sd,
                'persen_smp' => $persen_smp,
                'persen_sma' => $persen_sma,
                'percentage' => $percentage,
                'total' => $total,
                'column' => $request->name,
                'percentage_column' => $percentage_column,
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
        //     PesertaDidik::create([
        //         'desa_id' => $value->id,
        //         'jumlah_kelas_1' => 0,
        //         'pelayanan_kelas_1' => 0,
        //         'jumlah_kelas_7' => 0,
        //         'pelayanan_kelas_7' => 0,
        //         'jumlah_kelas_10' => 0,
        //         'pelayanan_kelas_10' => 0,
        //         'jumlah_usia_dasar' => 0,
        //         'pelayanan_usia_dasar' => 0,
        //         'jumlah_sd' => 0,
        //         'pelayanan_sd' => 0,
        //         'jumlah_smp' => 0,
        //         'pelayanan_smp' => 0,
        //         'jumlah_sma' => 0,
        //         'pelayanan_sma' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_kelas_1 = 0;
    $total_pelayanan_kelas_1 = 0;
    $total_kelas_7 = 0;
    $total_pelayanan_kelas_7 = 0;
    $total_kelas_10 = 0;
    $total_pelayanan_kelas_10 = 0;
    $total_usia_dasar = 0;
    $total_pelayanan_usia_dasar = 0;
    $total_sd = 0;
    $total_pelayanan_sd = 0;
    $total_smp = 0;
    $total_pelayanan_smp = 0;
    $total_sma = 0;
    $total_pelayanan_sma = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterPesertaDidik(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterPesertaDidik(Session::get('year'))){
                $total_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_1;
            $total_pelayanan_kelas_1 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_1;
            $total_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_7;
            $total_pelayanan_kelas_7 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_7;
            $total_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->jumlah_kelas_10;
            $total_pelayanan_kelas_10 += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_kelas_10;
            $total_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->jumlah_usia_dasar;
            $total_pelayanan_usia_dasar += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_usia_dasar;
            $total_sd += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sd;
            $total_pelayanan_sd += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sd;
            $total_smp += $desa->filterPesertaDidik(Session::get('year'))->jumlah_smp;
            $total_pelayanan_smp += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_smp;
            $total_sma += $desa->filterPesertaDidik(Session::get('year'))->jumlah_sma;
            $total_pelayanan_sma += $desa->filterPesertaDidik(Session::get('year'))->pelayanan_sma;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_kelas_1 += $desa->jumlah_kelas_1(Session::get('year'));
            $total_pelayanan_kelas_1 += $desa->pelayanan_kelas_1(Session::get('year'));
            $total_kelas_7 += $desa->jumlah_kelas_7(Session::get('year'));
            $total_pelayanan_kelas_7 += $desa->pelayanan_kelas_7(Session::get('year'));
            $total_kelas_10 +=$desa->jumlah_kelas_10(Session::get('year'));
            $total_pelayanan_kelas_10 += $desa->pelayanan_kelas_10(Session::get('year'));
            $total_usia_dasar += $desa->jumlah_usia_dasar(Session::get('year'));
            $total_pelayanan_usia_dasar += $desa->pelayanan_usia_dasar(Session::get('year'));
            $total_sd += $desa->jumlah_sd(Session::get('year'));
            $total_pelayanan_sd += $desa->pelayanan_sd(Session::get('year'));
            $total_smp += $desa->jumlah_smp(Session::get('year'));
            $total_pelayanan_smp += $desa->pelayanan_smp(Session::get('year'));
            $total_sma += $desa->jumlah_sma(Session::get('year'));
            $total_pelayanan_sma += $desa->pelayanan_sma(Session::get('year'));
        }
    }

    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Peserta Didik")->first();
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
        'total_kelas_1' => $total_kelas_1,
        'total_pelayanan_kelas_1' => $total_pelayanan_kelas_1,
        'total_kelas_7' => $total_kelas_7,
        'total_pelayanan_kelas_7' => $total_pelayanan_kelas_7,
        'total_kelas_10' => $total_kelas_10,
        'total_pelayanan_kelas_10' => $total_pelayanan_kelas_10,
        'total_usia_dasar' => $total_usia_dasar,
        'total_pelayanan_usia_dasar' => $total_pelayanan_usia_dasar,
        'total_sd' => $total_sd,
        'total_pelayanan_sd' => $total_pelayanan_sd,
        'total_smp' => $total_smp,
        'total_pelayanan_smp' => $total_pelayanan_smp,
        'total_sma' => $total_sma,
        'total_pelayanan_sma' => $total_pelayanan_sma,
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
        $unitKerja->PesertaDidikLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new PesertaDidikExport, 'peserta_didik_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
