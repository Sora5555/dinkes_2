<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table85;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table85Controller extends Controller
{
    protected $routeName = 'table_85';
    protected $viewName = 'input_data.table_85';
    protected $title = 'KASUS COVID-19 BERDASARKAN JENIS KELAMIN DAN KELOMPOK UMUR MENURUT KECAMATAN DAN PUSKESMAS';

    public function index(Request $request)
    {
        if(Table85::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table85::create([
                    'desa_id' => $value->id,
                    'l_0_4' => 1,
                    'p_0_4' => 1,
                    'l_5_6' => 1,
                    'p_5_6' => 1,
                    'l_7_14' => 1,
                    'p_7_14' => 1,
                    'l_15_59' => 1,
                    'p_15_59' => 1,
                    'l_60_up' => 1,
                    'p_60_up' => 1,
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
    
        $fillable = (new Table85())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable85($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table85($data);
    
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
            $data = Table85::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');


            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;

            $l_total_ = $data->l_0_4 + $data->l_5_6 + $data->l_7_14 + $data->l_15_59 + $data->l_60_up;
            $p_total_ = $data->p_0_4 + $data->p_5_6 + $data->p_7_14 + $data->p_15_59 + $data->p_60_up;

            $Grand_l_0_4 = Table85::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_0_4');
            $Grand_p_0_4 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_0_4');

            $Grand_l_5_6 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_5_6');
            $Grand_p_5_6 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_5_6');

            $Grand_l_7_14 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_7_14');
            $Grand_p_7_14 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_7_14');

            $Grand_l_15_59 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_15_59');
            $Grand_p_15_59 = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_15_59');

            $Grand_l_60_up = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_60_up');
            $Grand_p_60_up = Table85::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_60_up');

            $Grand_l_total = $Grand_l_0_4 + $Grand_l_5_6 + $Grand_l_7_14 + $Grand_l_15_59 + $Grand_l_60_up;
            $Grand_p_total = $Grand_p_0_4 + $Grand_p_5_6 + $Grand_p_7_14 + $Grand_p_15_59 + $Grand_p_60_up;


            return response()->json([
                'status' => 'success',

                'l_total_'.$data->id => $l_total_,
                'p_total_'.$data->id => $p_total_,

                'Grand_l_0_4' => $Grand_l_0_4,
                'Grand_p_0_4' => $Grand_p_0_4,
                'Grand_l_5_6' => $Grand_l_5_6,
                'Grand_p_5_6' => $Grand_p_5_6,
                'Grand_l_7_14' => $Grand_l_7_14,
                'Grand_p_7_14' => $Grand_p_7_14,
                'Grand_l_15_59' => $Grand_l_15_59,
                'Grand_p_15_59' => $Grand_p_15_59,
                'Grand_l_60_up' => $Grand_l_60_up,
                'Grand_p_60_up' => $Grand_p_60_up,
                'Grand_l_total' => $Grand_l_total,
                'Grand_p_total' => $Grand_p_total,



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
}
