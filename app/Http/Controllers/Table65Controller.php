<?php

namespace App\Http\Controllers;

use App\Exports\Table65Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table64;
use App\Models\Table65;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table65Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'table_65';
    protected $viewName = 'input_data.table_65';
    protected $title = 'KASUS BARU KUSTA CACAT TINGKAT 0, CACAT TINGKAT 2, PENDERITA KUSTA ANAK<15 TAHUN,';
    public function index(Request $request)
    {
        //
        // dd(Desa::all());
        if(Table65::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table65::create([
                    'desa_id' => $value->id,
                    'jumlah_cacat_0' => 1,
                    'jumlah_cacat_1' => 1,
                    'penderita_kusta_1' => 1,
                    'penderita_kusta_2' => 1,
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
    
        $fillable = (new Table65())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable65($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table65($data);
    
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
            $data = Table65::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $persen_jumlah_cacat_0_ = number_format(($data->jumlah_cacat_0 / $data->PenderitaKusta($data->desa_id)) * 100, 2)."%";
            $persen_jumlah_cacat_1_ = number_format(($data->jumlah_cacat_1 / $data->PenderitaKusta($data->desa_id)) * 100, 2)."%";
            $persen_penderita_kusta_1_ = number_format(($data->penderita_kusta_1 / $data->PenderitaKusta($data->desa_id)) * 100, 2)."%";

            $GrandPenderitaKusta = 0;
            foreach(Table65::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->get() as $a) {
                $GrandPenderitaKusta += $a->PenderitaKusta($a->desa_id);
            }

            $GrandJumlah_cacat_0 = Table65::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('jumlah_cacat_0');
            $PGrandCacat0 =  number_format(($GrandJumlah_cacat_0 / $GrandPenderitaKusta) * 100, 2)."%";
            $GrandJumlah_cacat_1 = Table65::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_cacat_1');
            $PGrandCacat1 = number_format(($GrandJumlah_cacat_1 / $GrandPenderitaKusta) * 100, 2)."%";
            $GrandPenderita_kusta_1 = Table65::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('penderita_kusta_1');
            $PGrandPenderitaKusta1 = number_format(($GrandPenderita_kusta_1 / $GrandPenderitaKusta) * 100, 2)."%";
            $GrandPenderita_kusta_2 = Table65::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('penderita_kusta_2');

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');
            $lp_case = ($GrandJumlah_cacat_1 / ($jumlah_penduduk_laki_laki + $jumlah_penduduk_perempuan)) * 100000;


            return response()->json([
                'status' => 'success',
                "persen_jumlah_cacat_0_" => $persen_jumlah_cacat_0_,
                "persen_jumlah_cacat_1_" => $persen_jumlah_cacat_1_,
                "persen_penderita_kusta_1_" => $persen_penderita_kusta_1_,
                "GrandPenderitaKusta" => $GrandPenderitaKusta,
                "GrandJumlah_cacat_0" => $GrandJumlah_cacat_0,
                "PGrandCacat0" => $PGrandCacat0,
                "GrandJumlah_cacat_1" =>  $GrandJumlah_cacat_1,
                "PGrandCacat1" => $PGrandCacat1,
                "GrandPenderita_kusta_1" => $GrandPenderita_kusta_1,
                "PGrandPenderitaKusta1" => $PGrandPenderitaKusta1,
                "GrandPenderita_kusta_2" => $GrandPenderita_kusta_2,
                'angka_cacat_2_penduduk' =>  $lp_case,
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
            return Excel::download(new Table65Export, 'KASUS BARU KUSTA CACAT TINGKAT 0, CACAT TINGKAT 2, PENDERITA KUSTA ANAK<15 TAHUN_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
