<?php

namespace App\Http\Controllers;

use App\Exports\Table66Export;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\JumlahPenduduk;
use App\Models\Table65;
use App\Models\Table66;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class Table66Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'table_66';
    protected $viewName = 'input_data.table_66';
    protected $title = 'JUMLAH KASUS TERDAFTAR DAN ANGKA PREVALENSI PENYAKIT KUSTA MENURUT TIPE/JENIS, USIA, KECAMATAN, DAN PUSKESMAS';
    public function index(Request $request)
    {
        //
        // dd(Desa::all());
        if(Table66::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                Table66::create([
                    'desa_id' => $value->id,
                    'pausi_anak' => 1,
                    'pausi_dewasa' => 1,
                    'multi_anak' => 1,
                    'multi_dewasa' => 1,
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
    
        $fillable = (new Table66())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterTable66($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new Table66($data);
    
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
            $data = Table66::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $total_pausi = $data->pausi_anak + $data->pausi_dewasa;
            $total_multi =  $data->multi_anak + $data->multi_dewasa;
            $jumlah_anak = $data->pausi_anak + $data->multi_anak;
            $jumlah_dewasa = $data->pausi_dewasa + $data->multi_dewasa;
            $jumlah_total = $jumlah_anak + $jumlah_dewasa;

            $GrandPausi_anak = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pausi_anak');
            $GrandPausi_dewasa = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pausi_dewasa');

            $GrandPausi_total = $GrandPausi_anak + $GrandPausi_dewasa;

            $GrandMulti_anak = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('multi_anak');
            $GrandMulti_dewasa = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('multi_dewasa');

            $GrandMulti_total = $GrandMulti_anak + $GrandMulti_dewasa;

            $GrandJumlah_anak = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pausi_anak') +  Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('multi_anak');

            $GrandJumlah_dewasa = Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('pausi_dewasa') + Table66::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('multi_dewasa');

            $GrandJumlah_total = $GrandJumlah_anak + $GrandJumlah_dewasa;

            $jumlah_penduduk_laki_laki = JumlahPenduduk::sum('laki_laki');
            $jumlah_penduduk_perempuan = JumlahPenduduk::sum('perempuan');
            $angka_prevalensi = ($GrandJumlah_total / ($jumlah_penduduk_laki_laki + $jumlah_penduduk_perempuan)) * 10000;


            return response()->json([
                'status' => 'success',
                "total_pausi" => $total_pausi,
                "total_multi" => $total_multi,
                "jumlah_anak" => $jumlah_anak,
                "jumlah_dewasa" => $jumlah_dewasa,
                "jumlah_total" => $jumlah_total,

                'GrandPausi_anak' => $GrandPausi_anak,
                'GrandPausi_dewasa' => $GrandPausi_dewasa,
                'GrandPausi_total' => $GrandPausi_total,
                'GrandMulti_anak' => $GrandMulti_anak,
                'GrandMulti_dewasa' => $GrandMulti_dewasa,
                'GrandMulti_total' => $GrandMulti_total,
                'GrandJumlah_anak' => $GrandJumlah_anak,
                'GrandJumlah_dewasa' => $GrandJumlah_dewasa,
                'GrandJumlah_total' => $GrandJumlah_total,

                'angka_prevalensi' => $angka_prevalensi,

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
            return Excel::download(new Table66Export, 'JUMLAH KASUS TERDAFTAR DAN ANGKA PREVALENSI PENYAKIT KUSTA MENURUT TIPE ATAU JENIS, USIA, KECAMATAN, DAN PUSKESMAS_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
