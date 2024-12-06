<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table87;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table87Controller extends Controller
{
    protected $routeName = 'table_87';
    protected $viewName = 'input_data.table_87';
    protected $title = 'CAKUPAN VAKSINASI COVID-19 DOSIS 2 MENURUT KECAMATAN DAN PUSKESMAS';

    public function index(Request $request)
    {
        if(Table87::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table87::create([
                    'desa_id' => $value->id,
                    'sasaran_6_11' => 1,
                    'hasil_vaksinasi_6_11' => 1,
                    'sasaran_12_17' => 1,
                    'hasil_vaksinasi_12_17' => 1,
                    'sasaran_18_59' => 1,
                    'hasil_vaksinasi_18_59' => 1,
                    'sasaran_60_up' => 1,
                    'hasil_vaksinasi_60_up' => 1,
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
    
        $fillable = (new Table87())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable87($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table87($data);
    
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
            $data = Table87::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');
            $persen_6_11_ = number_format(($data->hasil_vaksinasi_6_11 / $data->sasaran_6_11) * 100, 2) . '%';
            $persen_12_17_ = number_format(($data->hasil_vaksinasi_12_17 / $data->sasaran_12_17) * 100, 2) . '%';
            $persen_18_59_ = number_format(($data->hasil_vaksinasi_18_59 / $data->sasaran_18_59) * 100, 2) . '%';
            $persen_60_up_ = number_format(($data->hasil_vaksinasi_60_up / $data->sasaran_60_up) * 100, 2) . '%';
            $total_sasaran_ = $data->sasaran_6_11 + $data->sasaran_12_17 + $data->sasaran_18_59 + $data->sasaran_60_up;
            $total_hasil_vaksinasi_ =  $data->hasil_vaksinasi_6_11 + $data->hasil_vaksinasi_12_17 + $data->hasil_vaksinasi_18_59 + $data->hasil_vaksinasi_60_up;
            $total_persen_ = number_format(($total_hasil_vaksinasi_ / $total_sasaran_) * 100, 2) . '%';

            $Grandsasaran_6_11 = Table87::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('sasaran_6_11');
            $Grandhasil_vaksinasi_6_11 = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hasil_vaksinasi_6_11');
            $Grandpersen_6_11 = number_format(($Grandhasil_vaksinasi_6_11 / $Grandsasaran_6_11) * 100, 2) . '%';

            $Grandsasaran_12_17 = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('sasaran_12_17');
            $Grandhasil_vaksinasi_12_17 = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hasil_vaksinasi_12_17');
            $Grandpersen_12_17 = number_format(($Grandhasil_vaksinasi_12_17 / $Grandsasaran_12_17) * 100, 2) . '%';

            $Grandsasaran_18_59 = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('sasaran_18_59');
            $Grandhasil_vaksinasi_18_59 = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hasil_vaksinasi_18_59');
            $Grandpersen_18_59 = number_format(($Grandhasil_vaksinasi_18_59 / $Grandsasaran_18_59) * 100, 2) . '%';

            $Grandsasaran_60_up = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('sasaran_60_up');
            $Grandhasil_vaksinasi_60_up = Table87::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('hasil_vaksinasi_60_up');
            $Grandpersen_60_up = number_format(($Grandhasil_vaksinasi_60_up / $Grandsasaran_60_up) * 100, 2) . '%';

            $Grandtotal_sasaran = $Grandsasaran_6_11 + $Grandsasaran_12_17 + $Grandsasaran_18_59 + $Grandsasaran_60_up;
            $Grandtotal_hasil_vaksinasi = $Grandhasil_vaksinasi_6_11 + $Grandhasil_vaksinasi_12_17 + $Grandhasil_vaksinasi_18_59 + $Grandhasil_vaksinasi_60_up;
            $Grandtotal_persen = number_format(($Grandtotal_hasil_vaksinasi / $Grandtotal_sasaran) * 100, 2);


            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;


            return response()->json([
                'status' => 'success',

                'persen_6_11_'.$data->id => $persen_6_11_,
                'persen_12_17_'.$data->id => $persen_12_17_,
                'persen_18_59_'.$data->id => $persen_18_59_,
                'persen_60_up_'.$data->id => $persen_60_up_,
                'total_sasaran_'.$data->id => $total_sasaran_,
                'total_hasil_vaksinasi_'.$data->id => $total_hasil_vaksinasi_,
                'total_persen_'.$data->id => $total_persen_,

                'Grandsasaran_6_11' => $Grandsasaran_6_11,
                'Grandhasil_vaksinasi_6_11' => $Grandhasil_vaksinasi_6_11,
                'Grandpersen_6_11' => $Grandpersen_6_11,
                'Grandsasaran_12_17' => $Grandsasaran_12_17,
                'Grandhasil_vaksinasi_12_17' => $Grandhasil_vaksinasi_12_17,
                'Grandpersen_12_17' => $Grandpersen_12_17,
                'Grandsasaran_18_59' => $Grandsasaran_18_59,
                'Grandhasil_vaksinasi_18_59' => $Grandhasil_vaksinasi_18_59,
                'Grandpersen_18_59' => $Grandpersen_18_59,
                'Grandsasaran_60_up' => $Grandsasaran_60_up,
                'Grandhasil_vaksinasi_60_up' => $Grandhasil_vaksinasi_60_up,
                'Grandpersen_60_up' => $Grandpersen_60_up,
                'Grandtotal_sasaran' => $Grandtotal_sasaran,
                'Grandtotal_hasil_vaksinasi' => $Grandtotal_hasil_vaksinasi,
                'Grandtotal_persen' => $Grandtotal_persen,
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
