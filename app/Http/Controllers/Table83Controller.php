<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table83;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table83Controller extends Controller
{
    protected $routeName = 'table_83';
    protected $viewName = 'input_data.table_83';
    protected $title = 'PERSENTASE TEMPAT PENGELOLAAN PANGAN (TPP) YANG MEMENUHI SYARAT KESEHATAN  MENURUT KECAMATAN';
    public function index(Request $request)
    {
        if(Table83::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table83::create([
                    'desa_id' => $value->id,

                    'jasa_boga_terdaftar' => 1,
                    'jasa_boga_jumlah' => 1,

                    'restoran_terdaftar' => 1,
                    'restoran_jumlah' => 1,

                    'tpp_tertentu_terdaftar' => 1,
                    'tpp_tertentu_jumlah' => 1,

                    'depot_air_minum_terdaftar' => 1,
                    'depot_air_minum_jumlah' => 1,

                    'rumah_makan_terdaftar' => 1,
                    'rumah_makan_jumlah' => 1,

                    'kelompok_gerai_terdaftar' => 1,
                    'kelompok_gerai_jumlah' => 1,

                    'sentra_pangan_terdaftar' => 1,
                    'sentra_pangan_jumlah' => 1,
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
    
        $fillable = (new Table83())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable83($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table83($data);
    
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
            $data = Table83::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');

            $persen_jasa_boga_ = number_format(($data->jasa_boga_jumlah / $data->jasa_boga_terdaftar) * 100, 2) . '%';
            $persen_restoran_ = number_format(($data->restoran_jumlah / $data->restoran_terdaftar) * 100, 2) . '%';
            $persen_tpp_tertentu_ = number_format(($data->tpp_tertentu_jumlah / $data->tpp_tertentu_terdaftar) * 100, 2) . '%';
            $persen_depot_air_minum_ = number_format(($data->depot_air_minum_jumlah / $data->depot_air_minum_terdaftar) * 100, 2) . '%';
            $persen_rumah_makan_ = number_format(($data->rumah_makan_jumlah / $data->rumah_makan_terdaftar) * 100, 2) . '%';
            $persen_kelompok_gerai_ = number_format(($data->kelompok_gerai_jumlah / $data->kelompok_gerai_terdaftar) * 100, 2) . '%';
            $persen_sentra_pangan_ = number_format(($data->sentra_pangan_jumlah / $data->sentra_pangan_terdaftar) * 100, 2) . '%';

            $terdaftar_tpp_memenuhi_syarat_ = $data->jasa_boga_terdaftar + $data->restoran_terdaftar + $data->tpp_tertentu_terdaftar + $data->depot_air_minum_terdaftar + $data->rumah_makan_terdaftar + $data->kelompok_gerai_terdaftar + $data->sentra_pangan_terdaftar;
            $jumlah_tpp_memenuhi_syarat_ = $data->jasa_boga_jumlah + $data->restoran_jumlah + $data->tpp_tertentu_jumlah + $data->depot_air_minum_jumlah + $data->rumah_makan_jumlah + $data->kelompok_gerai_jumlah + $data->sentra_pangan_jumlah;
            $persen_tpp_memenuhi_syarat_ = number_format(($jumlah_tpp_memenuhi_syarat_ / $terdaftar_tpp_memenuhi_syarat_) * 100, 2) . '%';


            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;

            $Grandjasa_boga_terdaftar = Table83::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('jasa_boga_terdaftar');
            $Grandjasa_boga_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('jasa_boga_jumlah');
            $Persen_Grandjasa_boga = number_format(($Grandjasa_boga_jumlah / $Grandjasa_boga_terdaftar) * 100, 2) . '%';

            $Grandrestoran_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('restoran_terdaftar');
            $Grandrestoran_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('restoran_jumlah');
            $Persen_Grandrestoran_jumlah = number_format(($Grandrestoran_jumlah / $Grandrestoran_terdaftar) * 100, 2) . '%';

            $Grandtpp_tertentu_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('tpp_tertentu_terdaftar');
            $Grandtpp_tertentu_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('tpp_tertentu_jumlah');
            $Persen_Grandtertentu_jumlah = number_format(($Grandtpp_tertentu_jumlah / $Grandtpp_tertentu_terdaftar) * 100, 2) . '%';

            $Granddepot_air_minum_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('depot_air_minum_terdaftar');
            $Granddepot_air_minum_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('depot_air_minum_jumlah');
            $Persen_Granddepot_air_minum = number_format(($Granddepot_air_minum_jumlah / $Granddepot_air_minum_terdaftar) * 100, 2) . '%';

            $Grandrumah_makan_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('rumah_makan_terdaftar');
            $Grandrumah_makan_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('rumah_makan_jumlah');
            $Persen_Grandrumah_makan = number_format(($Grandrumah_makan_jumlah / $Grandrumah_makan_terdaftar) * 100, 2) . '%';

            $Grandkelompok_gerai_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kelompok_gerai_terdaftar');
            $Grandkelompok_gerai_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kelompok_gerai_jumlah');
            $Persen_Grandkelompok_gerai = number_format(($Grandkelompok_gerai_jumlah / $Grandkelompok_gerai_terdaftar) * 100, 2) . '%';

            $Grandsentra_pangan_terdaftar = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('sentra_pangan_terdaftar');
            $Grandsentra_pangan_jumlah = Table83::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('sentra_pangan_jumlah');
            $Persen_Grandsentra_pangan = number_format(($Grandsentra_pangan_jumlah / $Grandsentra_pangan_terdaftar) * 100, 2) . '%';

            $Grandterdaftar_tpp_memenuhi_syarat = $Grandjasa_boga_terdaftar + $Grandrestoran_terdaftar + $Grandtpp_tertentu_terdaftar + $Granddepot_air_minum_terdaftar + $Grandrumah_makan_terdaftar + $Grandkelompok_gerai_terdaftar + $Grandsentra_pangan_terdaftar;
            $Grandjumlah_tpp_memenuhi_syarat = $Grandjasa_boga_jumlah + $Grandrestoran_jumlah + $Grandtpp_tertentu_jumlah + $Granddepot_air_minum_jumlah + $Grandrumah_makan_jumlah + $Grandkelompok_gerai_jumlah + $Grandsentra_pangan_jumlah;
            $Persen_Grand_tpp_memenuhi_syarat = number_format(($Grandterdaftar_tpp_memenuhi_syarat / $Grandjumlah_tpp_memenuhi_syarat) * 100, 2) . '%';



            return response()->json([
                'status' => 'success',
                'persen_jasa_boga_'.$data->id => $persen_jasa_boga_ ,
                'persen_restoran_'.$data->id => $persen_restoran_,
                'persen_tpp_tertentu_'.$data->id => $persen_tpp_tertentu_,
                'persen_depot_air_minum_'.$data->id => $persen_depot_air_minum_,
                'persen_rumah_makan_'.$data->id => $persen_rumah_makan_,
                'persen_kelompok_gerai_'.$data->id => $persen_kelompok_gerai_,
                'persen_sentra_pangan_'.$data->id => $persen_sentra_pangan_,
                'terdaftar_tpp_memenuhi_syarat_'.$data->id => $terdaftar_tpp_memenuhi_syarat_,
                'terdaftar_tpp_memenuhi_syarat_'.$data->id => $jumlah_tpp_memenuhi_syarat_,
                'persen_tpp_memenuhi_syarat_'.$data->id => $persen_tpp_memenuhi_syarat_,

                'Grandjasa_boga_terdaftar' => $Grandjasa_boga_terdaftar,
                'Grandjasa_boga_jumlah' => $Grandjasa_boga_jumlah,
                'Persen_Grandjasa_boga' => $Persen_Grandjasa_boga,
                'Grandrestoran_terdaftar' => $Grandrestoran_terdaftar,
                'Grandrestoran_jumlah' => $Grandrestoran_jumlah,
                'Persen_Grandrestoran_jumlah' => $Persen_Grandrestoran_jumlah,
                'Grandtpp_tertentu_terdaftar' => $Grandtpp_tertentu_terdaftar,
                'Grandtpp_tertentu_jumlah' => $Grandtpp_tertentu_jumlah,
                'Persen_Grandtertentu_jumlah' => $Persen_Grandtertentu_jumlah,
                'Granddepot_air_minum_terdaftar' => $Granddepot_air_minum_terdaftar,
                'Granddepot_air_minum_jumlah' => $Granddepot_air_minum_jumlah,
                'Persen_Granddepot_air_minum' => $Persen_Granddepot_air_minum,
                'Grandrumah_makan_terdaftar' => $Grandrumah_makan_terdaftar,
                'Grandrumah_makan_jumlah' => $Grandrumah_makan_jumlah,
                'Persen_Grandrumah_makan' => $Persen_Grandrumah_makan,
                'Grandkelompok_gerai_terdaftar' => $Grandkelompok_gerai_terdaftar,
                'Grandkelompok_gerai_jumlah' => $Grandkelompok_gerai_jumlah,
                'Persen_Grandkelompok_gerai' => $Persen_Grandkelompok_gerai,
                'Grandsentra_pangan_terdaftar' => $Grandsentra_pangan_terdaftar,
                'Grandsentra_pangan_jumlah' => $Grandsentra_pangan_jumlah,
                'Persen_Grandsentra_pangan' => $Persen_Grandsentra_pangan,
                'Grandterdaftar_tpp_memenuhi_syarat' => $Grandterdaftar_tpp_memenuhi_syarat,
                'Grandjumlah_tpp_memenuhi_syarat' => $Grandjumlah_tpp_memenuhi_syarat,
                'Persen_Grand_tpp_memenuhi_syarat' => $Persen_Grand_tpp_memenuhi_syarat,

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
