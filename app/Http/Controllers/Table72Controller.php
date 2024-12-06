<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table72;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table72Controller extends Controller
{
    protected $routeName = 'table_72';
    protected $viewName = 'input_data.table_72';
    protected $title = 'KASUS DEMAM BERDARAH DENGUE (DBD) MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        if(Table72::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table72::create([
                    'desa_id' => $value->id,
                    'l_kasus' => 1,
                    'p_kasus' => 1,
                    'l_meninggal' => 1,
                    'p_meninggal' => 1,
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
    
        $fillable = (new Table72())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable72($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table72($data);
    
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
            $data = Table72::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            // $klb_p_ = number_format(($data->ditangani_24 / $data->jumlah) * 100, 2) . '%';

            // $GrandJumlah = Table70::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('jumlah');

            // $Grandditangani_24 = Table70::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('ditangani_24');

            // $GrandKLB_P = number_format(($Grandditangani_24 / $GrandJumlah) * 100, 2) . '%';

            $lp_kasus_ = $data->l_kasus + $data->p_kasus;
            $lp_meninggal_ = $data->l_meninggal + $data->p_meninggal;
            $l_kasus_meninggal_ = $data->l_kasus + $data->l_meninggal;
            $p_kasus_meninggal_ = $data->p_kasus + $data->p_meninggal;
            $lp_kasus_meninggal_ = $l_kasus_meninggal_ + $p_kasus_meninggal_;


            $Grandl_kasus = Table72::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_kasus');
            $Grandp_kasus = Table72::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_kasus');
            $Grandpl_kasus = $Grandl_kasus + $Grandp_kasus;

            $Grandl_meninggal = Table72::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_meninggal');
            $Grandp_meninggal = Table72::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_meninggal');
            $Grandpl_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            $Grandl_kasus_meninggal = $Grandl_kasus + $Grandl_meninggal;
            $Grandp_kasus_meninggal =  $Grandp_kasus + $Grandp_meninggal;
            $Grandpl_kasus_meninggal = $Grandl_kasus_meninggal + $Grandp_kasus_meninggal;

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            $angka = ($Grandpl_kasus / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 100000;

            return response()->json([
                'status' => 'success',

                'lp_kasus_' => $lp_kasus_,
                'lp_meninggal_' => $lp_meninggal_,
                'l_kasus_meninggal_' => $l_kasus_meninggal_,
                'p_kasus_meninggal_' => $p_kasus_meninggal_,
                'lp_kasus_meninggal_' => $lp_kasus_meninggal_,

                'Grandl_kasus' => $Grandl_kasus,
                'Grandp_kasus' => $Grandp_kasus,
                'Grandpl_kasus' => $Grandpl_kasus,

                'Grandl_meninggal' => $Grandl_meninggal,
                'Grandp_meninggal' => $Grandp_meninggal,
                'Grandpl_meninggal' => $Grandpl_meninggal,

                'Grandl_kasus_meninggal' => $Grandl_kasus_meninggal,
                'Grandp_kasus_meninggal' => $Grandp_kasus_meninggal,
                'Grandpl_kasus_meninggal' => $Grandpl_kasus_meninggal,

                'angka' => $angka,

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
