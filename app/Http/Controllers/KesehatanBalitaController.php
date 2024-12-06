<?php

namespace App\Http\Controllers;

use App\Exports\KesehatanBalitaExport;
use App\Models\Desa;
use App\Models\IndukOpd;
use App\Models\KesehatanBalita;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class KesehatanBalitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'kesehatan_balita';
    protected $viewName = 'kesehatan_balita';
    protected $title = 'kesehatan_balita';
    public function index(Request $request)
    {
    $unit_kerja = UnitKerja::all();
    $totalbalita_0_59 = 0;
    $totalbalita_12_59 = 0;
    $totalbalita_kia = 0;
    $totalbalita_dipantau = 0;
    $totalbalita_sdidtk = 0;
    $totalbalita_mtbs = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterKesehatanBalita(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterKesehatanBalita(Session::get('year'))){
                $totalbalita_0_59 += $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59;
                $totalbalita_12_59 += $desa->filterKesehatanBalita(Session::get('year'))->balita_12_59;
                $totalbalita_kia += $desa->filterKesehatanBalita(Session::get('year'))->balita_kia;
                $totalbalita_dipantau += $desa->filterKesehatanBalita(Session::get('year'))->balita_dipantau;
                $totalbalita_sdidtk += $desa->filterKesehatanBalita(Session::get('year'))->balita_sdidtk;
                $totalbalita_mtbs += $desa->filterKesehatanBalita(Session::get('year'))->balita_mtbs;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $totalbalita_0_59 += $desa->balita_0_59(Session::get('year'));
            $totalbalita_12_59 += $desa->balita_12_59(Session::get('year'));
            $totalbalita_kia += $desa->balita_kia(Session::get('year'));
            $totalbalita_dipantau += $desa->balita_dipantau(Session::get('year'));
            $totalbalita_sdidtk += $desa->balita_sdidtk(Session::get('year'));
            $totalbalita_mtbs += $desa->balita_mtbs(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'totalbalita_0_59' => $totalbalita_0_59,
        'totalbalita_12_59' => $totalbalita_12_59,
        'totalbalita_kia' => $totalbalita_kia,
        'totalbalita_dipantau' => $totalbalita_dipantau,
        'totalbalita_sdidtk' => $totalbalita_sdidtk,
        'totalbalita_mtbs' => $totalbalita_mtbs,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.index')->with($data);
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
        //
        try {
            $kesehatan_balita = KesehatanBalita::where('id', $request->id)->first();
            // dd($request->name, $request->value);
            $kesehatan_balita->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $persen_balita_kia = (int)$kesehatan_balita->balita_kia/$kesehatan_balita->balita_0_59*100;
            $persen_balita_dipantau = (int)$kesehatan_balita->balita_dipantau/$kesehatan_balita->balita_0_59*100;
            $persen_balita_sdidtk = ((int)$kesehatan_balita->balita_sdidtk)/($kesehatan_balita->balita_12_59)*100;
            $persen_balita_mtbs = (int)$kesehatan_balita->balita_mtbs/$kesehatan_balita->balita_0_59*100;
            $desa = $kesehatan_balita->Desa->UnitKerja;
            $total = 0;
            $totalbalita_0_59 = 0;
            $totalbalita_12_59 = 0;
            $percentage = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value);
                $totalbalita_0_59 += $value->filterKesehatanBalita(Session::get('year'))->balita_0_59;
                $totalbalita_12_59 += $value->filterKesehatanBalita(Session::get('year'))->balita_12_59;
                $total += $value->filterKesehatanBalita(Session::get('year'))->{$request->name};
            }
            if($request->name == "balita_sdidtk"){
                $percentage = $totalbalita_12_59 > 0?number_format($total/$totalbalita_12_59 * 100, 2):0;
            } else if($request->name == "balita_kia" || $request->name == "balita_dipantau" || $request->name == "balita_mtbs") {
                $percentage = $totalbalita_0_59 > 0?number_format($total/$totalbalita_0_59 * 100, 2):0;
            }
            
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'persen_balita_kia' => $persen_balita_kia,
                'persen_balita_dipantau' => $persen_balita_dipantau,
                'persen_balita_sdidtk' => $persen_balita_sdidtk,
                'persen_balita_mtbs' => $persen_balita_mtbs,
                'percentage' => $percentage,
                'total' => $total,
                'column' => $request->name,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage(),
            ]);
        }
    }
    public function add(Request $request)
{
    $counter = 0;

    $fillable = (new KesehatanBalita())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterKesehatanBalita(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            KesehatanBalita::create($data);
            $counter++;
        }
    }
    return redirect()->route($this->routeName . '.index')->with(['success' => 'Berhasil!']);
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

    public function report(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     KesehatanBalita::create([
        //         'desa_id' => $value->id,
        //         'balita_0_59' => 0,
        //         'balita_12_59' => 0,
        //         'balita_kia' => 0,
        //         'balita_dipantau' => 0,
        //         'balita_sdidtk' => 0,
        //         'balita_mtbs' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $totalbalita_0_59 = 0;
    $totalbalita_12_59 = 0;
    $totalbalita_kia = 0;
    $totalbalita_dipantau = 0;
    $totalbalita_sdidtk = 0;
    $totalbalita_mtbs = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterKesehatanBalita(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterKesehatanBalita(Session::get('year'))){
                $totalbalita_0_59 += $desa->filterKesehatanBalita(Session::get('year'))->balita_0_59;
                $totalbalita_12_59 += $desa->filterKesehatanBalita(Session::get('year'))->balita_12_59;
                $totalbalita_kia += $desa->filterKesehatanBalita(Session::get('year'))->balita_kia;
                $totalbalita_dipantau += $desa->filterKesehatanBalita(Session::get('year'))->balita_dipantau;
                $totalbalita_sdidtk += $desa->filterKesehatanBalita(Session::get('year'))->balita_sdidtk;
                $totalbalita_mtbs += $desa->filterKesehatanBalita(Session::get('year'))->balita_mtbs;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $totalbalita_0_59 += $desa->balita_0_59(Session::get('year'));
            $totalbalita_12_59 += $desa->balita_12_59(Session::get('year'));
            $totalbalita_kia += $desa->balita_kia(Session::get('year'));
            $totalbalita_dipantau += $desa->balita_dipantau(Session::get('year'));
            $totalbalita_sdidtk += $desa->balita_sdidtk(Session::get('year'));
            $totalbalita_mtbs += $desa->balita_mtbs(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);
    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Kesehatan Balita")->first();
    $nama_pengelola = "";
    $nip_pengelola = "";
    if($pengelola_program){
        $nama_pengelola = $pengelola_program->nama;
        $nip_pengelola = $pengelola_program->nip;
    }
    if(Session::get('year')){
        $tahun = Session::get('year');
    } else {
        $tahun = Carbon::now()->format('Y');
    }

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'totalbalita_0_59' => $totalbalita_0_59,
        'totalbalita_12_59' => $totalbalita_12_59,
        'totalbalita_kia' => $totalbalita_kia,
        'totalbalita_dipantau' => $totalbalita_dipantau,
        'totalbalita_sdidtk' => $totalbalita_sdidtk,
        'totalbalita_mtbs' => $totalbalita_mtbs,
        'nama_pengelola' => $nama_pengelola,
        'nip_pengelola' => $nip_pengelola,
        'tahun' => $tahun,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.report')->with($data);
}
    public function apiLock(Request $request){

        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->KesehatanBalitaLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new KesehatanBalitaExport, 'kesehatan_balita_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
