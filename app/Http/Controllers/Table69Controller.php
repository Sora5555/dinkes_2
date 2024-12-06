<?php

namespace App\Http\Controllers;

use App\Exports\Table69Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table69;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table69Controller extends Controller
{
    protected $routeName = 'table_69';
    protected $viewName = 'input_data.table_69';
    protected $title = 'JUMLAH KASUS PENYAKIT YANG DAPAT DICEGAH DENGAN IMUNISASI (PD3I) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        if(Table69::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table69::create([
                    'desa_id' => $value->id,
                    'difteri_l' => 1,
                    'difteri_p' => 1,
                    'difteri_lp' => 1,
                    'difteri_m' => 1,
                    'pertusis_l' => 1,
                    'pertusis_p' => 1,
                    'pertusis_lp' => 1,
                    'tetanus_neonatorum_l' => 1,
                    'tetanus_neonatorum_p' => 1,
                    'tetanus_neonatorum_lp' => 1,
                    'tetanus_neonatorum_m' => 1,
                    'hepatitis_l' => 1,
                    'hepatitis_p' => 1,
                    'hepatitis_lp' => 1,
                    'suspek_campak_l' => 1,
                    'suspek_campak_p' => 1,
                    'suspek_campak_lp' => 1,
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
    
        $fillable = (new Table69())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable69($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table69($data);
    
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
    public function store(Request $request)
    {
        try {
            $data = Table69::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $difteri_lp_ = $data->difteri_l + $data->difteri_p;
            $pertusis_lp_ = $data->pertusis_l + $data->pertusis_p;
            $tetanus_neonatorum_lp_ = $data->tetanus_neonatorum_l + $data->tetanus_neonatorum_p;
            $hepatitis_lp_ = $data->hepatitis_l + $data->hepatitis_p;
            $suspek_campak_lp_ = $data->suspek_campak_l + $data->suspek_campak_p;

            $Granddifteri_l = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('difteri_l');

            $Granddifteri_p = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('difteri_p');

            $Granddifteri_lp = $Granddifteri_l + $Granddifteri_p;

            $Granddifteri_m = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('difteri_m');

            $Grandpertusis_l = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pertusis_l');

            $Grandpertusis_p = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pertusis_p');

            $Grandpertusis_lp = $Grandpertusis_l + $Grandpertusis_p;

            $Grandtetanus_neonatorum_l = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('tetanus_neonatorum_l');

            $Grandtetanus_neonatorum_p = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('tetanus_neonatorum_p');

            $Grandtetanus_neonatorum_lp = $Grandtetanus_neonatorum_l + $Grandtetanus_neonatorum_p;

            $Grandtetanus_neonatorum_m = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('tetanus_neonatorum_m');

            $Grandhepatitis_l = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hepatitis_l');

            $Grandhepatitis_p = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hepatitis_p');

            $Grandhepatitis_lp = $Grandhepatitis_l + $Grandhepatitis_p;

            $Grandsuspek_campak_l = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('suspek_campak_l');

            $Grandsuspek_campak_p = Table69::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('suspek_campak_p');

            $Grandsuspek_campak_lp = $Grandsuspek_campak_l + $Grandsuspek_campak_p;

            $case_1 = number_format(($Granddifteri_m / $Granddifteri_lp) * 100, 2) . '%';
            $case_2 = number_format(($Grandtetanus_neonatorum_m / $Grandtetanus_neonatorum_lp) * 100, 2) . '%';

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            $incidence_1 = ($Grandsuspek_campak_l / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000;
            $incidence_2 = ($Grandsuspek_campak_p / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000;
            $incidence_3 = ($Grandsuspek_campak_lp / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000;

            return response()->json([
                'status' => 'success',
                'difteri_lp_' => $difteri_lp_,
                'pertusis_lp_' => $pertusis_lp_,
                'tetanus_neonatorum_lp_' => $tetanus_neonatorum_lp_,
                'hepatitis_lp_' => $hepatitis_lp_,
                'suspek_campak_lp_' => $suspek_campak_lp_,

                'Granddifteri_l' => $Granddifteri_l,
                'Granddifteri_p' => $Granddifteri_p,
                'Granddifteri_lp' => $Granddifteri_lp,
                'Granddifteri_m' => $Granddifteri_m,
                'Grandpertusis_l' => $Grandpertusis_l ,
                'Grandpertusis_p' => $Grandpertusis_p ,
                'Grandpertusis_lp' => $Grandpertusis_lp ,
                'Grandtetanus_neonatorum_l' => $Grandtetanus_neonatorum_l ,
                'Grandtetanus_neonatorum_p' => $Grandtetanus_neonatorum_p ,
                'Grandtetanus_neonatorum_lp' => $Grandtetanus_neonatorum_lp,
                'Grandtetanus_neonatorum_m' => $Grandtetanus_neonatorum_m ,
                'Grandhepatitis_l' => $Grandhepatitis_l ,
                'Grandhepatitis_p' => $Grandhepatitis_p ,
                'Grandhepatitis_lp' => $Grandhepatitis_lp ,
                'Grandsuspek_campak_l' => $Grandsuspek_campak_l ,
                'Grandsuspek_campak_p' => $Grandsuspek_campak_p,
                'Grandsuspek_campak_lp' => $Grandsuspek_campak_lp,

                'case_1' => $case_1,
                'case_2' => $case_2,

                'incidence_1' => $incidence_1,
                'incidence_2' => $incidence_2,
                'incidence_3' => $incidence_3,
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
            return Excel::download(new Table69Export, 'JUMLAH KASUS PENYAKIT YANG DAPAT DICEGAH DENGAN IMUNISASI (PD3I) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
