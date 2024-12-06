<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table74;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table74Controller extends Controller
{
    protected $routeName = 'table_74';
    protected $viewName = 'input_data.table_74';
    protected $title = 'PENDERITA KRONIS FILARIASIS MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        if(Table74::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table74::create([
                    'desa_id' => $value->id,
                    'kronis_t_sebelumnya_l' => 1,
                    'kronis_t_sebelumnya_p' => 1,
                    'kronis_b_ditemukan_l' => 1,
                    'kronis_b_ditemukan_p' => 1,
                    'kronis_pindah_l' => 1,
                    'kronis_pindah_p' => 1,
                    'kronis_meninggal_l' => 1,
                    'kronis_meninggal_p' => 1,
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
    
        $fillable = (new Table74())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable74($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table74($data);
    
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
            $data = Table74::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);;

            // $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            $kronis_t_sebelumnya_pl_ = $data->kronis_t_sebelumnya_l + $data->kronis_t_sebelumnya_p;
            $kronis_b_ditemukan_pl_ = $data->kronis_b_ditemukan_l + $data->kronis_b_ditemukan_p;
            $kronis_pindah_pl_ = $data->kronis_pindah_l + $data->kronis_pindah_p;
            $kronis_meninggal_pl_ = $data->kronis_meninggal_l + $data->kronis_meninggal_p;
            $jumlah_seluruh_kasus_l_ = $data->kronis_t_sebelumnya_l + $data->kronis_b_ditemukan_l + $data->kronis_pindah_l + $data->kronis_meninggal_l;
            $jumlah_seluruh_kasus_p_ = $data->kronis_t_sebelumnya_p + $data->kronis_b_ditemukan_p + $data->kronis_pindah_p + $data->kronis_meninggal_p;
            $jumlah_seluruh_kasus_pl_ = $jumlah_seluruh_kasus_l_ + $jumlah_seluruh_kasus_p_;



            // $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('p_meninggal');

            $Grandkronis_t_sebelumnya_l = Table74::whereHas('Desa', function ($a) {
                    $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
                })->sum('kronis_t_sebelumnya_l');

            $Grandkronis_t_sebelumnya_p = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_t_sebelumnya_p');

            $Grandkronis_t_sebelumnya_pl_ = $Grandkronis_t_sebelumnya_l + $Grandkronis_t_sebelumnya_p ;

            $Grandkronis_b_ditemukan_l = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_b_ditemukan_l');

            $Grandkronis_b_ditemukan_p = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_b_ditemukan_p');

            $Grandkronis_b_ditemukan_pl_ = $Grandkronis_b_ditemukan_l + $Grandkronis_b_ditemukan_p;

            $Grandkronis_pindah_l = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_pindah_l');

            $Grandkronis_pindah_p = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_pindah_p');

            $Grandkronis_pindah_pl_ = $Grandkronis_pindah_l + $Grandkronis_pindah_p;

            $Grandkronis_meninggal_l = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_meninggal_l');
            $Grandkronis_meninggal_p = Table74::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('kronis_meninggal_p');
            $Grandkronis_meninggal_pl_ = $Grandkronis_meninggal_l + $Grandkronis_meninggal_p;

            $Grandjumlah_seluruh_kasus_l_ = $Grandkronis_t_sebelumnya_l + $Grandkronis_b_ditemukan_l + $Grandkronis_pindah_l + $Grandkronis_meninggal_l;
            $Grandjumlah_seluruh_kasus_p_ = $Grandkronis_t_sebelumnya_p + $Grandkronis_b_ditemukan_p + $Grandkronis_pindah_p + $Grandkronis_meninggal_p;
            $Grandjumlah_seluruh_kasus_pl_ = $Grandjumlah_seluruh_kasus_l_ + $Grandjumlah_seluruh_kasus_p_;

            // $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            // $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            // $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');

            // $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;


            return response()->json([
                'status' => 'success',

                'kronis_t_sebelumnya_pl_'.$data->id => $kronis_t_sebelumnya_pl_,
                'kronis_b_ditemukan_pl_'.$data->id => $kronis_b_ditemukan_pl_,
                'kronis_pindah_pl_'.$data->id => $kronis_pindah_pl_,
                'kronis_meninggal_pl_'.$data->id => $kronis_meninggal_pl_,
                'jumlah_seluruh_kasus_l_'.$data->id => $jumlah_seluruh_kasus_l_,
                'jumlah_seluruh_kasus_p_'.$data->id => $jumlah_seluruh_kasus_p_,
                'jumlah_seluruh_kasus_pl_'.$data->id => $jumlah_seluruh_kasus_pl_,

                'Grandkronis_t_sebelumnya_l' => $Grandkronis_t_sebelumnya_l,
                'Grandkronis_t_sebelumnya_p' => $Grandkronis_t_sebelumnya_p,
                'Grandkronis_t_sebelumnya_pl_' => $Grandkronis_t_sebelumnya_pl_,
                'Grandkronis_b_ditemukan_l' => $Grandkronis_b_ditemukan_l,
                'Grandkronis_b_ditemukan_p' => $Grandkronis_b_ditemukan_p,
                'Grandkronis_b_ditemukan_pl_' => $Grandkronis_b_ditemukan_pl_,
                'Grandkronis_pindah_l' => $Grandkronis_pindah_l,
                'Grandkronis_pindah_p' => $Grandkronis_pindah_p,
                'Grandkronis_pindah_pl_' => $Grandkronis_pindah_pl_,
                'Grandkronis_meninggal_l' => $Grandkronis_meninggal_l,
                'Grandkronis_meninggal_p' => $Grandkronis_meninggal_p,
                'Grandkronis_meninggal_pl_' => $Grandkronis_meninggal_pl_,
                'Grandjumlah_seluruh_kasus_l_' => $Grandjumlah_seluruh_kasus_l_,
                'Grandjumlah_seluruh_kasus_p_' => $Grandjumlah_seluruh_kasus_p_,
                'Grandjumlah_seluruh_kasus_pl_' => $Grandjumlah_seluruh_kasus_pl_,
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
