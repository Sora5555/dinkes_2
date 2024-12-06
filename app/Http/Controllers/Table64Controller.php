<?php

namespace App\Http\Controllers;

use App\Exports\Table64Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table64;
use App\Models\UnitKerja;
use DivisionByZeroError;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table64Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'table_64';
    protected $viewName = 'input_data.table_64';
    protected $title = 'KASUS BARU KUSTA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        //
        // dd(Desa::all());
        if(Table64::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table64::create([
                    'desa_id' => $value->id,
                    'l_pb' => 1,
                    'p_pb' => 1,
                    'l_mb' => 1,
                    'p_mb' => 1,
                ]);
            }
        }
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
    
        $fillable = (new Table64())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable64($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table64($data);
    
                // Manually set created_at and updated_at
                $createdAt = Carbon::create($sessionYear, 1, 1);
                 // Default to Jan 1st, 00:00
                $result->created_at = $createdAt;
                $result->updated_at = $createdAt;
    
                // Save the model instance
                $result->save();
    
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
        try {
            $data = Table64::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            $pl_pb_ = $data->p_pb + $data->l_pb;
            $pl_mb_ = $data->p_mb + $data->l_mb;
            $ll_PBMB_ = $data->l_pb + $data->l_mb;
            $pp_PBMB_ = $data->p_mb + $data->p_pb;
            $pl_PBMB_ = $ll_PBMB_ + $pp_PBMB_;

            $GrandL_PB = Table64::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_pb');
            $GrandP_PB = Table64::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_pb');
            $GrandLP_PB = $GrandL_PB + $GrandP_PB;
            $GrandL_MB = Table64::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_mb');
            $GrandP_MB = Table64::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_mb');
            $GrandLP_MB = $GrandL_MB + $GrandP_MB;
            $GrandL_PBMB = $GrandL_PB + $GrandL_MB;
            $GrandP_PBMB = $GrandP_PB + $GrandP_MB;
            $GrandLP_PBMB =  $GrandL_PBMB + $GrandP_PBMB;

            try {
                $PGrandL_PB = number_format(($GrandL_PB / $GrandLP_PB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandL_PB = "0";
            }

            try {
                $PGrandP_PB = number_format(($GrandP_PB / $GrandLP_PB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandP_PB = "0";
            }

            try {
                $PGrandL_MB = number_format(($GrandL_MB / $GrandLP_MB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandL_MB = "0";
            }

            try {
                $PGrandP_MB = number_format(($GrandP_MB / $GrandLP_MB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandP_MB = "0";
            }

            try {
                $PGrandL_PBMB = number_format(($GrandL_PBMB / $GrandLP_PBMB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandL_PBMB = "0";
            }

            try {
                $PGrandP_PBMB = number_format(($GrandP_PBMB / $GrandLP_PBMB) * 100, 2)."%";
            } catch (DivisionByZeroError $e) {
                $PGrandP_PBMB =  "0";
            }

            $l_case = ($GrandL_PBMB / $jumlah_penduduk_laki_laki) * 100000;
            $p_case = ($GrandP_PBMB / $jumlah_penduduk_perempuan) * 100000;
            $lp_case = ($GrandLP_PBMB / ($jumlah_penduduk_laki_laki + $jumlah_penduduk_perempuan)) * 100000;

            return response()->json([
                'status' => 'success',
                "pl_pb_" => $pl_pb_,
                "pl_mb_" => $pl_mb_,
                "ll_PBMB_" => $ll_PBMB_,
                "pp_PBMB_" => $pp_PBMB_,
                "pl_PBMB_" => $pl_PBMB_,

                "GrandL_PB" => $GrandL_PB,
                "GrandP_PB" => $GrandP_PB,
                "GrandLP_PB" => $GrandLP_PB,
                "GrandL_MB" => $GrandL_MB,
                "GrandP_MB" => $GrandP_MB,
                "GrandLP_MB" => $GrandLP_MB,
                "GrandL_PBMB" => $GrandL_PBMB,
                "GrandP_PBMB" => $GrandP_PBMB,
                "GrandLP_PBMB" => $GrandLP_PBMB,

                "PGrandL_PB" => $PGrandL_PB,
                "PGrandP_PB" => $PGrandP_PB,
                "PGrandL_MB" => $PGrandL_MB,
                "PGrandP_MB" => $PGrandP_MB,
                "PGrandL_PBMB" => $PGrandL_PBMB,
                "PGrandP_PBMB" => $PGrandP_PBMB,

                "l_case" => $l_case,
                "p_case" => $p_case,
                "lp_case" => $lp_case,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
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
    public function exportExcel()
    {
        try {
            return Excel::download(new Table64Export, 'KASUS BARU KUSTA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
