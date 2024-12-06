<?php

namespace App\Http\Controllers;

use App\Exports\Table71Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table71;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table71Controller extends Controller
{
    protected $routeName = 'table_71';
    protected $viewName = 'input_data.table_71';
    protected $title = 'JUMLAH PENDERITA DAN KEMATIAN PADA KLB MENURUT JENIS KEJADIAN LUAR BIASA (KLB)';
    public function index(Request $request)
    {
        $table71 = Table71::whereYear('created_at', Session::get('year'))->get();

        // dd($table71);
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);

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
        // // dd($desa->filterDesa(null));
        // if(Auth::user()->roles->first()->name !== "Admin"){
        //     $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        //     foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
        //         if($desa->filterDiabetes($request->query('year'))){
        //             $total_diabetes += $desa->filterDiabetes($request->query('year'))->jumlah;
        //             $total_pelayanan_diabetes += $desa->filterDiabetes($request->query('year'))->pelayanan;
        //         }
        //     }
        // } else{
        //     foreach($unit_kerja as $desa){
        //         $total_diabetes += $desa->jumlah_diabetes($request->query('year'));
        //         $total_pelayanan_diabetes += $desa->pelayanan_diabetes($request->query('year'));
        //     }
        // }

        // dd(Auth::user()->unit_kerja_id);

        // dd(UnitKerja::first()->jumlah_k1);
        // dd($this->routeName);

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
            'jumlah_penduduk_laki_laki' => JumlahPenduduk::sum('laki_laki'),
            'jumlah_penduduk_perempuan' => JumlahPenduduk::sum('perempuan'),
            'table71' => $table71,
            // 'jabatan' => Jabatan::get(),
            // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
            // 'unit_organisasi' => UnitOrganisasi::get()
        ];

        // dd($data['jumlah_penduduk_perempuan']);

        return view($this->viewName.'.index')->with($data);
    }
    public function add(Request $request)
    {
        $counter = 0;
    
        $fillable = (new Table71())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

        $data = [];
    
        foreach ($fillable as $field) {
            // Set desa_id and default values for other fields
            $data[$field] = 0;
        }

        // Create a model instance
        $result = new Table71($data);

        // Manually set created_at and updated_at
        $createdAt = Carbon::create($sessionYear, 1, 1);
         // Default to Jan 1st, 00:00
        $result->created_at = $createdAt;
        $result->updated_at = $createdAt;

        // Save the model instance
        $result->save();
    
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


        try {
            $data = Table71::create([
                'jenis_kejadian' => "-",
                'jumlah_kec' => 0,
                'jumlah_desa' => 0,
                'diketahui' => 0,
                'ditanggulangi' => 0,
                'akhir' => 0,
                'l_pen' => 1,
                'p_pen' => 1,
                'k_0_7_hari' => 1,
                'k_8_28_hari' => 1,
                'k_1_11_bulan' => 1,
                'k_1_4_tahun' => 1,
                'k_5_9_tahun' => 1,
                'k_10_14_tahun' => 1,
                'k_15_19_tahun' => 1,
                'k_20_44_tahun' => 1,
                'k_45_54_tahun' => 1,
                'k_55_59_tahun' => 1,
                'k_60_69_tahun' => 1,
                'k_70_plus_tahun' => 1,
                'l_mati' => 1,
                'p_mati' => 1,
                'l_penduduk' => 1,
                'p_penduduk' => 1,
            ]);

            $count = Table71::count();

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'count' => $count,

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
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
        try {

            $data = Table71::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $lp_pen_ = $data->l_pen + $data->p_pen;
            $lp_mati_ = $data->l_mati + $data->p_mati;
            $lp_penduduk_ = $data->l_penduduk + $data->p_penduduk;

            $L_Attack_ = number_format(($data->l_pen / $data->l_penduduk) * 100, 2) . '%';
            $P_Attack_ = number_format(($data->p_pen / $data->p_penduduk) * 100, 2) . '%';
            $LP_Attack_ = number_format(($lp_pen_ / $lp_penduduk_) * 100, 2) . '%';

            $L_CFR_ = number_format(($data->l_pen / $data->l_mati) * 100, 2) . '%';
            $P_CFR_ = number_format(($data->p_pen / $data->p_mati) * 100, 2) . '%';
            $LP_CFR_ = number_format(($lp_pen_ / $lp_mati_) * 100, 2) . '%';

            return response()->json([
                'status' => 'success',
                'lp_pen_'.$data->id => $lp_pen_,
                'lp_mati_'.$data->id => $lp_mati_,
                'lp_penduduk_'.$data->id => $lp_penduduk_,
                'L_Attack_'.$data->id => $L_Attack_,
                'P_Attack_'.$data->id => $P_Attack_,
                'LP_Attack_'.$data->id => $LP_Attack_,
                'L_CFR_'.$data->id => $L_CFR_,
                'P_CFR_'.$data->id => $P_CFR_,
                'LP_CFR_'.$data->id => $LP_CFR_,

            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
            ]);
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

            $data = Table71::find($id);
            $data->delete();

            return response()->json([
                'status' => 'success',
                'id' => $id,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
    
            ]);
        }

    }
    public function exportExcel()
    {
        try {
            return Excel::download(new Table71Export, 'JUMLAH PENDERITA DAN KEMATIAN PADA KLB MENURUT JENIS KEJADIAN LUAR BIASA (KLB)_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
