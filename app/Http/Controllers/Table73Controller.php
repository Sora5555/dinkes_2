<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table73;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;

class Table73Controller extends Controller
{
    protected $routeName = 'table_73';
    protected $viewName = 'input_data.table_73';
    protected $title = 'KESAKITAN DAN KEMATIAN AKIBAT MALARIA MENURUT JENIS KELAMIN, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        if(Table73::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table73::create([
                    'desa_id' => $value->id,
                    'suspek' => 1,
                    'mikroskopis' => 1,
                    'rapid' => 1,
                    'l_positif' => 1,
                    'p_positif' => 1,
                    'pengobatan_standar' => 1,
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
    
        $fillable = (new Table73())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable73($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table73($data);
    
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
            $data = Table73::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $total_ = $data->mikroskopis + $data->rapid;
            $konfirmasi_ = number_format(($total_ / $data->suspek) * 100, 2) . '%';
            $lp_positif_ = $data->l_positif + $data->p_positif;
            $pengobatan_s_persen_ = number_format(($data->pengobatan_standar / $lp_positif_) * 100, 2) . '%';
            $lp_meninggal_ = $data->l_meninggal + $data->p_meninggal;
            $l_cfr_ = number_format(($data->l_meninggal / $data->l_positif) * 100, 2) . '%';
            $p_cfr_ = number_format(($data->p_meninggal / $data->p_positif) * 100, 2) . '%';
            $lp_cfr_ = number_format(($lp_meninggal_ / $lp_positif_) * 100, 2) . '%';

            $Grandsuspek = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('suspek');

            $Grandmikroskopis = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('mikroskopis');

            $Grandrapid = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('rapid');

            $Grandtotal = $Grandmikroskopis + $Grandrapid;

            $Grandkonfirmasi = number_format(($Grandtotal / $Grandsuspek) * 100, 2) . '%';

            $Grandl_positif = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_positif');

            $Grandp_positif = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_positif');

            $Grandlp_positif = $Grandl_positif + $Grandp_positif;

            $Grandpengobatan_standar = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pengobatan_standar');

            $Grandpengobatan_s_persen = number_format(($Grandpengobatan_standar / $Grandlp_positif) * 100, 2) . '%';
            $Grandl_meninggal = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('l_meninggal');

            $Grandp_meninggal = Table73::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('p_meninggal');

            $Grandlp_meninggal = $Grandl_meninggal + $Grandp_meninggal;

            $Grandl_cfr = number_format(($Grandl_meninggal / $Grandl_positif) * 100, 2) . '%';
            $Grandp_cfr = number_format(($Grandp_meninggal / $Grandp_positif) * 100, 2) . '%';
            $Grandlp_cfr = number_format(($Grandlp_meninggal / $Grandlp_positif) * 100, 2) . '%';

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');
            $angka_kesakitan = ($Grandlp_positif / ($jumlah_penduduk_perempuan + $jumlah_penduduk_laki_laki)) * 1000;


            return response()->json([
                'status' => 'success',
                'total_'.$data->id => $total_,
                'konfirmasi_'.$data->id => $konfirmasi_,
                'lp_positif_'.$data->id => $lp_positif_,
                'pengobatan_s_persen_'.$data->id => $pengobatan_s_persen_,
                'lp_meninggal_'.$data->id => $lp_meninggal_,
                'l_cfr_'.$data->id => $l_cfr_,
                'p_cfr_'.$data->id => $p_cfr_,
                'lp_cfr_'.$data->id => $lp_cfr_,

                'Grandsuspek' => $Grandsuspek,
                'Grandmikroskopis' => $Grandmikroskopis,
                'Grandrapid' => $Grandrapid,
                'Grandtotal' => $Grandtotal,
                'Grandkonfirmasi' => $Grandkonfirmasi,
                'Grandl_positif' => $Grandl_positif,
                'Grandp_positif' => $Grandp_positif,
                'Grandlp_positif' => $Grandlp_positif,
                'Grandpengobatan_standar' => $Grandpengobatan_standar,
                'Grandpengobatan_s_persen'  => $Grandpengobatan_s_persen,
                'Grandl_meninggal' => $Grandl_meninggal,
                'Grandp_meninggal' => $Grandp_meninggal,
                'Grandlp_meninggal' => $Grandlp_meninggal,
                'Grandl_cfr' => $Grandl_cfr,
                'Grandp_cfr' => $Grandp_cfr,
                'Grandlp_cfr' => $Grandlp_cfr,

                'angka_kesakitan' => $angka_kesakitan,

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
