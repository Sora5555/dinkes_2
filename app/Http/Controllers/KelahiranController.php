<?php

namespace App\Http\Controllers;

use App\Exports\KelahiranExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\Kelahiran;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class KelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'kelahiran';
    protected $viewName = 'kelahiran';
    protected $title = 'kelahiran';
    public function index(Request $request)
    {
        // return NPA::whereHas('kategori',function($query){
        //     $query->where('kategori','Industri Besar');
        // })->get();
        // dd($request->all());

        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Kelahiran::create([
        //         'lahir_hidup_L' => 0,
        //         'lahir_mati_L' => 0,
        //         'lahir_hidup_P' => 0,
        //         'lahir_mati_P' => 0,
        //         'desa_id' => $value->id,
        //     ]);
        // }
            $unit_kerja1 = UnitKerja::first();
            // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
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
        // dd(Auth::user()->unit_kerja->Desa()->get());
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
            foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
                if($desa->filterDesa(Session::get('year'))){
                    $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
                $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
                $totalk4 += $desa->filterDesa(Session::get('year'))->k4;
                $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
                $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
                $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
                $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
                $totalvita += $desa->filterDesa(Session::get('year'))->vita;
                $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
                }
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

    $fillable = (new Kelahiran())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterKelahiran(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            Kelahiran::create($data);
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
            $kelahiran = Kelahiran::where('id', $request->id)->first();
            $kelahiran->update([
                $request->name => $request->value,
            ]);
            $lahir_L = $kelahiran->lahir_hidup_L + $kelahiran->lahir_mati_L;
            $lahir_P = $kelahiran->lahir_hidup_P + $kelahiran->lahir_mati_P;
            $lahir_hidup_LP = $kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L;
            $lahir_mati_LP = $kelahiran->lahir_mati_P + $kelahiran->lahir_mati_L;
            $lahir_mati_hidup_LP = $kelahiran->lahir_hidup_P + $kelahiran->lahir_mati_P + $kelahiran->lahir_hidup_L + $kelahiran->lahir_mati_L;

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
                'lahir_L' => $lahir_L,
                'lahir_P' => $lahir_P,
                'lahir_hidup_LP' => $lahir_hidup_LP,
                'lahir_mati_LP' => $lahir_mati_LP,
                'lahir_hidup_mati_LP' => $lahir_mati_hidup_LP
                // 'column' => $request->name,
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
    public function apiLock(Request $request){

        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->KelahiranLock($request->year, $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new KelahiranExport, 'kelahiran_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
