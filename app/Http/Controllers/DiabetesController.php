<?php

namespace App\Http\Controllers;

use App\Exports\DiabetesExport;
use App\Models\Desa;
use App\Models\Diabetes;
use App\Models\IndukOpd;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class DiabetesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'diabetes';
    protected $viewName = 'diabetes';
    protected $title = 'diabetes';
    public function index(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Diabetes::create([
        //         'desa_id' => $value->id,
        //         'jumlah' => 0,
        //         'pelayanan' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_diabetes = 0;
    $total_pelayanan_diabetes = 0;
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
            if($desa->filterDiabetes(Session::get('year'))){
                $total_diabetes += $desa->filterDiabetes(Session::get('year'))->jumlah;
                $total_pelayanan_diabetes += $desa->filterDiabetes(Session::get('year'))->pelayanan;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_diabetes += $desa->jumlah_diabetes(Session::get('year'));
            $total_pelayanan_diabetes += $desa->pelayanan_diabetes(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'total_diabetes' => $total_diabetes,
        'total_pelayanan_diabetes' => $total_pelayanan_diabetes,
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

    $fillable = (new Diabetes())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterDiabetes(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Diabetes::create($data);
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
            $diabetes = Diabetes::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $diabetes->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $persen = (int)$diabetes->pelayanan / $diabetes->jumlah*100;
            
            $total = 0;
            $total_diabetes = 0;
            $total_pelayanan_diabetes = 0;
            $desa = $diabetes->Desa->UnitKerja;
            $percentage = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $total += $value->filterDiabetes(Session::get('year'))->{$request->name};
                $total_diabetes += $value->filterDiabetes(Session::get('year'))->jumlah;
                $total_pelayanan_diabetes += $value->filterDiabetes(Session::get('year'))->pelayanan;
            }
            $percentage = $total_diabetes>0?number_format($total_pelayanan_diabetes/$total_diabetes*100, 2):0;

            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'persen' => $persen,
                'total' => $total,
                'column' => $request->name,
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
        //     Diabetes::create([
        //         'desa_id' => $value->id,
        //         'jumlah' => 0,
        //         'pelayanan' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $total_diabetes = 0;
    $total_pelayanan_diabetes = 0;
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
        foreach(Auth::user()->unit_kerja->Desa()->get()()->get()()->get()()->get()()->get() as $desa){
            if($desa->filterDiabetes(Session::get('year'))){
                $total_diabetes += $desa->filterDiabetes(Session::get('year'))->jumlah;
                $total_pelayanan_diabetes += $desa->filterDiabetes(Session::get('year'))->pelayanan;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $total_diabetes += $desa->jumlah_diabetes(Session::get('year'));
            $total_pelayanan_diabetes += $desa->pelayanan_diabetes(Session::get('year'));
        }
    }


    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Diabetes")->first();
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
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get()()->get()()->get()()->get()()->get()()->get()()->get():Desa::all(),
        'total_diabetes' => $total_diabetes,
        'total_pelayanan_diabetes' => $total_pelayanan_diabetes,
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
        $unitKerja->DiabetesLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new DiabetesExport, 'Diabetes_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
