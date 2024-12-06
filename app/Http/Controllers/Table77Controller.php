<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table77;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table77Controller extends Controller
{
    protected $routeName = 'table_77';
    protected $viewName = 'input_data.table_77';
    protected $title = 'CAKUPAN DETEKSI DINI KANKER LEHER RAHIM DENGAN METODE IVA DAN KANKER PAYUDARA DENGAN PEMERIKSAAN KLINIS (SADANIS)';
    public function index(Request $request)
    {
        if(Table77::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table77::create([
                    'desa_id' => $value->id,
                    'kegiatan_deteksi' => 1,
                    'perempuan_30_50_tahun' => 1,
                    'jumlah_iva' => 1,
                    'jumlah_sadanis' => 1,
                    'jumlah_iva_positif' => 1,
                    'jumlah_curiga' => 1,
                    'jumlah_krioterapi' => 1,
                    'jumlah_iva_positif_dan_curiga_kanker_leher' => 1,
                    'jumlah_tumor' => 1,
                    'jumlah_kanker_payudara' => 1,
                    'jumlah_tumor_curiga_kanker_payudara_dirujuk' => 1,
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
    
        $fillable = (new Table77())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable77($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table77($data);
    
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
            $data = Table77::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            $persen_iva_ = number_format(($data->jumlah_iva / $data->perempuan_30_50_tahun) * 100, 2) . '%';
            $persen_sadanis_ = number_format(($data->jumlah_sadanis / $data->perempuan_30_50_tahun) * 100, 2) . '%';
            $persen_iva_positif_ = number_format(($data->jumlah_iva_positif / $data->jumlah_iva) * 100, 2) . '%';
            $persen_curiga_ = number_format(($data->jumlah_curiga / $data->jumlah_iva) * 100, 2) . '%';
            $persen_krioterapi_ = number_format(($data->jumlah_krioterapi / $data->jumlah_iva_positif) * 100, 2) . '%';
            $persen_iva_positif_dan_curiga_kanker_leher_ = number_format(($data->jumlah_krioterapi / ($data->jumlah_iva_positif - $data->jumlah_krioterapi + $data->jumlah_curiga )) * 100, 2) . '%';
            $persen_tumor_ = number_format(($data->jumlah_tumor / $data->jumlah_sadanis) * 100, 2) . '%';
            $persen_kanker_payudara_ = number_format(($data->jumlah_kanker_payudara / $data->jumlah_sadanis) * 100, 2) . '%';
            $persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_ = number_format(($data->jumlah_tumor_curiga_kanker_payudara_dirujuk / ($data->jumlah_tumor + $data->jumlah_kanker_payudara )) * 100, 2) . '%';

            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');

            $Grandkegiatan_deteksi = Table77::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('kegiatan_deteksi');
            $Grandperempuan_30_50_tahun = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('perempuan_30_50_tahun');
            $Grandjumlah_iva = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_iva');
            $Grand_persen_iva_ = number_format(($Grandjumlah_iva / $Grandperempuan_30_50_tahun) * 100, 2) . '%';

            $Grandjumlah_sadanis = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_sadanis');
            $Grand_persen_sadanis_ = number_format(($Grandjumlah_sadanis / $Grandperempuan_30_50_tahun) * 100, 2) . '%';

            $Grandjumlah_iva_positif = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_iva_positif');
            $Grand_persen_iva_positif_ = number_format(($Grandjumlah_iva_positif / $Grandjumlah_iva) * 100, 2) . '%';

            $Grandjumlah_curiga = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_curiga');
            $Grand_persen_curiga_ = number_format(($Grandjumlah_curiga / $Grandjumlah_iva) * 100, 2) . '%';

            $Grandjumlah_krioterapi = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_krioterapi');
            $Grand_persen_krioterapi_ = number_format(($Grandjumlah_krioterapi / $Grandjumlah_iva_positif) * 100, 2) . '%';

            $Grandjumlah_iva_positif_dan_curiga_kanker_leher = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_iva_positif_dan_curiga_kanker_leher');
            $Grand_persen_iva_positif_dan_curiga_kanker_leher_ = number_format(($Grandjumlah_iva_positif_dan_curiga_kanker_leher / ($Grandjumlah_iva_positif - $Grandjumlah_krioterapi + $Grandjumlah_curiga )) * 100, 2) . '%';

            $Grandjumlah_tumor = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_tumor');
            $Grand_persen_tumor_ = number_format(($Grandjumlah_tumor / $Grandjumlah_sadanis) * 100, 2) . '%';

            $Grandjumlah_kanker_payudara = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_kanker_payudara');
            $Grand_persen_kanker_payudara_ = number_format(($Grandjumlah_kanker_payudara / $Grandjumlah_sadanis) * 100, 2) . '%';

            $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk = Table77::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jumlah_tumor_curiga_kanker_payudara_dirujuk');
            $Grand_persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_ = number_format(($Grandjumlah_tumor_curiga_kanker_payudara_dirujuk / ($Grandjumlah_tumor + $Grandjumlah_kanker_payudara )) * 100, 2) . '%';



            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;


            return response()->json([
                'status' => 'success',
                'persen_iva_'.$data->id => $persen_iva_,
                'persen_sadanis_'.$data->id => $persen_sadanis_,
                'persen_iva_positif_'.$data->id => $persen_iva_positif_,
                'persen_curiga_'.$data->id => $persen_curiga_,
                'persen_krioterapi_'.$data->id => $persen_krioterapi_,
                'persen_iva_positif_dan_curiga_kanker_leher_'.$data->id => $persen_iva_positif_dan_curiga_kanker_leher_,
                'persen_tumor_'.$data->id => $persen_tumor_,
                'persen_kanker_payudara_'.$data->id => $persen_kanker_payudara_,
                'persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_'.$data->id => $persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_,

                'Grandkegiatan_deteksi' => $Grandkegiatan_deteksi ,
                'Grandperempuan_30_50_tahun' => $Grandperempuan_30_50_tahun ,
                'Grandjumlah_iva' => $Grandjumlah_iva ,
                'Grand_persen_iva_' => $Grand_persen_iva_ ,
                'Grandjumlah_sadanis' => $Grandjumlah_sadanis ,
                'Grand_persen_sadanis_' => $Grand_persen_sadanis_ ,
                'Grandjumlah_iva_positif' => $Grandjumlah_iva_positif ,
                'Grand_persen_iva_positif_' => $Grand_persen_iva_positif_ ,
                'Grandjumlah_curiga' => $Grandjumlah_curiga ,
                'Grand_persen_curiga_' => $Grand_persen_curiga_ ,
                'Grandjumlah_krioterapi' => $Grandjumlah_krioterapi ,
                'Grand_persen_krioterapi_' => $Grand_persen_krioterapi_ ,
                'Grandjumlah_iva_positif_dan_curiga_kanker_leher' => $Grandjumlah_iva_positif_dan_curiga_kanker_leher ,
                'Grand_persen_iva_positif_dan_curiga_kanker_leher_' => $Grand_persen_iva_positif_dan_curiga_kanker_leher_ ,
                'Grandjumlah_tumor' => $Grandjumlah_tumor ,
                'Grand_persen_tumor_' => $Grand_persen_tumor_ ,
                'Grandjumlah_kanker_payudara' => $Grandjumlah_kanker_payudara ,
                'Grand_persen_kanker_payudara_' => $Grand_persen_kanker_payudara_ ,
                'Grandjumlah_tumor_curiga_kanker_payudara_dirujuk' => $Grandjumlah_tumor_curiga_kanker_payudara_dirujuk ,
                'Grand_persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_' => $Grand_persen_jumlah_tumor_curiga_kanker_payudara_dirujuk_,
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
