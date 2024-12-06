<?php

namespace App\Http\Controllers;

use App\Exports\DeteksiDiniHepatitisBPIBExport;
use App\Models\Desa;
use App\Models\DeteksiDiniHepatitisBPadaIbuHamil;
use App\Models\IbuHamilDanBersalin;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
Use Session;

class DeteksiDiniHepatitisBPIBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $routeName = 'DeteksiDiniHepatitisBPIB';
     protected $viewName = 'DeteksiDiniHepatitisBPIB';
     protected $title = 'Deteksi Dini Hepatitis B Pada Ibu Hamil';
    public function index(Request $request)
    {
        //
        // dd(Desa::all());
        if(DeteksiDiniHepatitisBPadaIbuHamil::count() == 0) {
            foreach (Desa::all() as $key => $value) {
                # code...
                DeteksiDiniHepatitisBPadaIbuHamil::create([
                    'desa_id' => $value->id,
                    'reaktif' => 2,
                    'non_reaktif' => 3,
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
        // dd($desa->filterDesa(null));
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
            foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
                if($desa->filterDiabetes(Session::get('year'))){
                    $total_diabetes += $desa->filterDiabetes(Session::get('year'))->jumlah;
                    $total_pelayanan_diabetes += $desa->filterDiabetes(Session::get('year'))->pelayanan;
                }
            }
        } else{
            foreach($unit_kerja as $desa){
                $total_diabetes += $desa->jumlah_diabetes(Session::get('year'));
                $total_pelayanan_diabetes += $desa->pelayanan_diabetes(Session::get('year'));
            }
        }

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
            // 'jabatan' => Jabatan::get(),
            // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
            // 'unit_organisasi' => UnitOrganisasi::get()
        ];

        return view($this->viewName.'.index')->with($data);
    }
    public function add(Request $request)
    {
        $counter = 0;
    
        $fillable = (new DeteksiDiniHepatitisBPadaIbuHamil())->getFillable(); // Get only fillable attributes
        $sessionYear = Session::get('year'); // Retrieve the year from the session

    
        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            if ($desa->filterDeteksiDiniHepatitisBPadaIbuHamil($sessionYear, $desa->id)) {
                continue;
            } else {
                $data = [];
    
                foreach ($fillable as $field) {
                    // Set desa_id and default values for other fields
                    $data[$field] = $field === 'desa_id' ? $desa->id : 0;
                }
    
                // Create a model instance
                $result = new DeteksiDiniHepatitisBPadaIbuHamil($data);
    
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
            $data = DeteksiDiniHepatitisBPadaIbuHamil::where('id', $request->id)->first();

            $data->update([
                $request->name => $request->value,
            ]);

            $total = $data->reaktif + $data->non_reaktif;
            $bumil_diperiksa = number_format(($total / $data->IbuHamil($data->desa_id)) * 100, 2) . '%';
            $bumil_reaktif =  number_format(($data->reaktif / $total) * 100, 2) . '%' ;

            $jumlah_ibu_hamil = 0;
            foreach(DeteksiDiniHepatitisBPadaIbuHamil::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->get() as $a) {
                $jumlah_ibu_hamil += $a->IbuHamil($a->desa_id);
            }
            // $jumlah_ibu_hamil = IbuHamilDanBersalin::whereHas('Desa', function ($a) {
            //     $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            // })->sum('jumlah_ibu_hamil');

            $jumlah_reaktif =  DeteksiDiniHepatitisBPadaIbuHamil::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('reaktif');
            $jumlah_non_reaktif = DeteksiDiniHepatitisBPadaIbuHamil::whereHas('Desa', function ($a) {
                $a->where('unit_kerja_id', Auth::user()->unit_kerja_id);
            })->sum('non_reaktif');
            $jumlah_total = $jumlah_reaktif + $jumlah_non_reaktif;
            $jumlah_bumil_diperiksa = number_format(($jumlah_total / $jumlah_ibu_hamil) * 100, 2) . '%' ;
            $jumlah_bumil_reaktif =  number_format(($jumlah_reaktif / $jumlah_total) * 100, 2) . '%' ;


            return response()->json([
                'status' => 'success',
                'total' => $total,
                'bumil_diperiksa' => $bumil_diperiksa,
                'bumil_reaktif' => $bumil_reaktif,

                'jumlah_ibu_hamil' => $jumlah_ibu_hamil,
                'jumlah_reaktif' => $jumlah_reaktif,
                'jumlah_non_reaktif' => $jumlah_non_reaktif,
                'jumlah_total' => $jumlah_total,
                'jumlah_bumil_diperiksa' => $jumlah_bumil_diperiksa,
                'jumlah_bumil_reaktif' =>  $jumlah_bumil_reaktif,
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
            return Excel::download(new DeteksiDiniHepatitisBPIBExport, 'Deteksi Dini hepatitis Ibu hamil_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
