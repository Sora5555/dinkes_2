<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table82;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table82Controller extends Controller
{
    protected $routeName = 'table_82';
    protected $viewName = 'input_data.table_82';
    protected $title = 'PERSENTASE TEMPAT DAN FASILITAS UMUM(TFU) YANG DILAKUKAN PENGAWASAN SESUAI STANDAR MENURUT KECAMATAN DAN PUSKESMAS';
    public function index(Request $request)
    {
        if(Table82::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table82::create([
                    'desa_id' => $value->id,
                    'sd' => 1,
                    'smp' => 1,
                    'puskesmas' => 1,
                    'pasar' => 1,
                    'm_sd' => 1,
                    'm_smp' => 1,
                    'm_puskesmas' => 1,
                    'm_pasar' => 1,
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
    
        $fillable = (new Table82())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable82($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table82($data);
    
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
            $data = Table82::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');

            $total_ = $data->sd + $data->smp + $data->puskesmas + $data->pasar;
            $persen_sd_ = number_format(($data->m_sd / $data->sd) * 100, 2) . '%';
            $persen_smp_ = number_format(($data->m_smp / $data->smp) * 100, 2) . '%';
            $persen_puskesmas_ = number_format(($data->m_puskesmas / $data->puskesmas) * 100, 2) . '%';
            $persen_pasar_ = number_format(($data->m_pasar / $data->pasar) * 100, 2) . '%';
            $jumlah_total_ = $data->m_sd + $data->m_smp + $data->m_puskesmas + $data->m_pasar;
            $persen_total_ = number_format(($jumlah_total_ / $total_) * 100, 2) . '%';



            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;

            $Grandsd = Table82::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('sd');
            $Grandsmp = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('smp');
            $Grandpuskesmas = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('puskesmas');
            $Grandpasar = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pasar');

            $GrandTotal = $Grandsd + $Grandsmp + $Grandpuskesmas + $Grandpasar;

            $Grandm_sd = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('m_sd');
            $PersenGrandm_sd = number_format(($Grandm_sd / $Grandsd) * 100, 2) . '%';

            $Grandm_smp = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('m_smp');
            $PersenGrandm_smp = number_format(($Grandm_smp / $Grandsmp) * 100, 2) . '%';

            $Grandm_puskesmas = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('m_puskesmas');
            $PersenGrandm_puskesmas = number_format(($Grandm_puskesmas / $Grandpuskesmas) * 100, 2) . '%';

            $Grandm_pasar = Table82::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('m_pasar');
            $PersenGrandm_pasar = number_format(($Grandm_pasar / $Grandpasar) * 100, 2) . '%';

            $GrandMTotal = $Grandm_sd + $Grandm_smp + $Grandm_puskesmas + $Grandm_pasar;
            $PersenGrandMTotal = number_format(($GrandMTotal / $GrandTotal) * 100, 2) . '%';


            return response()->json([
                'status' => 'success',
                'total_'.$data->id => $total_,
                'persen_sd_'.$data->id => $persen_sd_,
                'persen_smp_'.$data->id => $persen_smp_,
                'persen_puskesmas_'.$data->id => $persen_puskesmas_,
                'persen_pasar_'.$data->id => $persen_pasar_,
                'jumlah_total_'.$data->id => $jumlah_total_,
                'persen_total_'.$data->id => $persen_total_,

                'Grandsd' => $Grandsd,
                'Grandsmp' => $Grandsmp,
                'Grandpuskesmas' => $Grandpuskesmas,
                'Grandpasar' => $Grandpasar,
                'GrandTotal' => $GrandTotal,
                'Grandm_sd' => $Grandm_sd,
                'PersenGrandm_sd' => $PersenGrandm_sd,
                'Grandm_smp' => $Grandm_smp,
                'PersenGrandm_smp' => $PersenGrandm_smp,
                'Grandm_puskesmas' => $Grandm_puskesmas,
                'PersenGrandm_puskesmas' => $PersenGrandm_puskesmas,
                'Grandm_pasar' => $Grandm_pasar,
                'PersenGrandm_pasar' => $PersenGrandm_pasar,
                'GrandMTotal' => $GrandMTotal,
                'PersenGrandMTotal' => $PersenGrandMTotal,

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
