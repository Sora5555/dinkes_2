<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Exports\NeonatalExport;
use Session;
use App\Models\Desa;
use App\Models\fileUpload;
use App\Models\IndukOpd;
use App\Models\Kelahiran;
use App\Models\Neonatal;
use App\Models\PengelolaProgram;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class NeonatalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'neonatal';
    protected $viewName = 'neonatal';
    protected $title = 'neonatal';
    public function index(Request $request)
    {
       
    $unit_kerja = UnitKerja::all();
    $totalLahirHidupL = 0;
    $totalLahirHidupP = 0;
    $totalkn1_L = 0;
    $totalkn1_P = 0;
    $totalkn_lengkap_L = 0;
    $totalkn_lengkap_P = 0;
    $totalhipo_L = 0;
    $totalhipo_P = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterNeonatal(Session::get('year'))){
                $totalLahirHidupL += $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L;
            $totalLahirHidupP += $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P;
            $totalkn1_L += $desa->filterNeonatal(Session::get('year'))->kn1_L;
            $totalkn1_P += $desa->filterNeonatal(Session::get('year'))->kn1_P;
            $totalkn_lengkap_L += $desa->filterNeonatal(Session::get('year'))->kn_lengkap_L;
            $totalkn_lengkap_P += $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P;
            $totalhipo_L += $desa->filterNeonatal(Session::get('year'))->hipo_L;
            $totalhipo_P += $desa->filterNeonatal(Session::get('year'))->hipo_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $totalLahirHidupL += $desa->lahir_hidup_L(Session::get('year'));
            $totalLahirHidupP += $desa->lahir_hidup_P(Session::get('year'));
            $totalkn1_L += $desa->kn1_L(Session::get('year'));
            $totalkn1_P += $desa->kn1_P(Session::get('year'));
            $totalkn_lengkap_L += $desa->kn_lengkap_L(Session::get('year'));
            $totalkn_lengkap_P += $desa->kn_lengkap_P(Session::get('year'));
            $totalhipo_L += $desa->hipo_L(Session::get('year'));
            $totalhipo_P += $desa->hipo_P(Session::get('year'));
        }
    }

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'totalLahirHidupL' => $totalLahirHidupL,
        'totalLahirHidupP' => $totalLahirHidupP,
        'totalkn1_L' => $totalkn1_L,
        'totalkn1_P' => $totalkn1_P,
        'totalkn_lengkap_L' => $totalkn_lengkap_L,
        'totalkn_lengkap_P' => $totalkn_lengkap_P,
        'totalhipo_L' => $totalhipo_L,
        'totalhipo_P' => $totalhipo_P,
        // 'jabatan' => Jabatan::get(),
        // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
        // 'unit_organisasi' => UnitOrganisasi::get()
    ];

    return view($this->viewName.'.index')->with($data);
}

    public function add(Request $request){
        $counter = 0;

        foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
            # code...
            if($desa->filterNeonatal(Session::get('year'))){
                continue;
            } else {
                Neonatal::create([
                    'desa_id' => $desa->id,
                    'kn1_L' => 0,
                    'kn1_P' => 0,
                    'kn_lengkap_L' => 0,
                    'kn_lengkap_P' => 0,
                    'hipo_L' => 0,
                    'hipo_P' => 0,
                ]);
                $counter++;
            }
        }
        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil!']);
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
            $Neonatal = Neonatal::where('id', $request->id)->first();
            $desa = $Neonatal->Desa;
            // dd($desa->desa);
            $kelahiran = Kelahiran::where('desa_id', $desa->id)->whereYear('created_at', $Neonatal->created_at->year)->first();
            // dd($request->name, $request->value);
            $Neonatal->update([
                $request->name => $request->value,
            ]);
            // dd($Neonatal->hipo_L, $kelahiran->lahir_hidup_L,  (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100);
            $persen_kn1_L = (int)$Neonatal->kn1_L/$kelahiran->lahir_hidup_L*100;
            $persen_kn1_P = (int)$Neonatal->kn1_P/$kelahiran->lahir_hidup_P*100;
            $persen_kn1_LP = ((int)$Neonatal->kn1_P + (int)$Neonatal->kn1_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L)*100;
            $jumlah_kn1_LP = $Neonatal->kn1_P + $Neonatal->kn1_L;
            $persen_kn_lengkap_L = (int)$Neonatal->kn_lengkap_L/$kelahiran->lahir_hidup_L*100;
            $persen_kn_lengkap_P = (int)$Neonatal->kn_lengkap_P/$kelahiran->lahir_hidup_P*100;
            $persen_kn_lengkap_LP = ((int)$Neonatal->kn_lengkap_P + (int)$Neonatal->kn_lengkap_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L)*100;
            $jumlah_kn_lengkap_LP = $Neonatal->kn_lengkap_P + $Neonatal->kn_lengkap_L;
            $persen_hipo_L = (int)$Neonatal->hipo_L/$kelahiran->lahir_hidup_L*100;
            $persen_hipo_P = (int)$Neonatal->hipo_P/$kelahiran->lahir_hidup_P*100;
            $persen_hipo_LP = ((int)$Neonatal->hipo_P + (int)$Neonatal->hipo_L)/($kelahiran->lahir_hidup_P + $kelahiran->lahir_hidup_L)*100;
            $jumlah_hipo_LP = $Neonatal->hipo_P + $Neonatal->hipo_L;
            $desa = $Neonatal->Desa->UnitKerja;
            $total = 0;
            $totalLahirHidupL = 0;
            $totalLahirHidupP = 0;
            $percentage = 0;
            $totalkn1_LP = 0;
            $totalkn_lengkap_LP = 0;
            $totalhipo_LP = 0;

            foreach ($desa->desa() as $key => $value) {
                # code...
                // dd($value);
                $totalLahirHidupL += $value->filterKelahiran(Session::get('year'))->lahir_hidup_L;
                $totalLahirHidupP += $value->filterKelahiran(Session::get('year'))->lahir_hidup_P;
                $total += $value->filterNeonatal(Session::get('year'))->{$request->name};
                $totalkn1_LP += $value->filterNeonatal(Session::get('year'))->kn1_L + $value->filterNeonatal(Session::get('year'))->kn1_P;
                $totalkn_lengkap_LP += $value->filterNeonatal(Session::get('year'))->kn_lengkap_L + $value->filterNeonatal(Session::get('year'))->kn_lengkap_P;
                $totalhipo_LP += $value->filterNeonatal(Session::get('year'))->hipo_L + $value->filterNeonatal(Session::get('year'))->hipo_P;
            }
            if($request->name == "kn1_L" || $request->name == "kn_lengkap_L"  || $request->name == "hipo_L"){
                $percentage = $totalLahirHidupL > 0?number_format($total/$totalLahirHidupL * 100, 2):0;
            } else {
               $percentage =  $totalLahirHidupP > 0?number_format($total/$totalLahirHidupP * 100, 2):0;
            }
            $persenkn1_LP =  $totalLahirHidupL + $totalLahirHidupP > 0?number_format($totalkn1_LP/($totalLahirHidupL + $totalLahirHidupP) * 100, 2):0;
            $persenkn_lengkap_LP =  $totalLahirHidupL + $totalLahirHidupP > 0?number_format($totalkn_lengkap_LP/($totalLahirHidupL + $totalLahirHidupP)* 100, 2):0;
            $persenhipo_LP =  $totalLahirHidupL + $totalLahirHidupP > 0?number_format($totalhipo_LP/($totalLahirHidupL + $totalLahirHidupP) * 100, 2):0;

            // dd($percentage);
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'persen_kn1_L' => $persen_kn1_L,
                'persen_kn1_P' => $persen_kn1_P,
                'persen_kn1_LP' => $persen_kn1_LP,
                'jumlah_kn1_LP' => $jumlah_kn1_LP,
                'persen_kn_lengkap_L' => $persen_kn_lengkap_L,
                'persen_kn_lengkap_P' => $persen_kn_lengkap_P,
                'persen_kn_lengkap_LP' => $persen_kn_lengkap_LP,
                'jumlah_kn_lengkap_LP' => $jumlah_kn_lengkap_LP,
                'persen_hipo_L' => $persen_hipo_L,
                'persen_hipo_P' => $persen_hipo_P,
                'persen_hipo_LP' => $persen_hipo_LP,
                'jumlah_hipo_LP' => $jumlah_hipo_LP,
                'totalkn1_LP' => $totalkn1_LP,
                'totalkn_lengkap_LP' => $totalkn_lengkap_LP,
                'totalhipo_LP' => $totalhipo_LP,
                'persenkn1_LP' => $persenkn1_LP,
                'persenkn_lengkap_LP' => $persenkn_lengkap_LP,
                'persenhipo_LP' => $persenhipo_LP,
                'column' => $request->name,
                'total' => $total,
                'percentage' => $percentage,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'fail',
                'message' => $th->getMessage(),
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
    public function report(Request $request)
    {
        //
        // $unit_kerja1 = UnitKerja::first();
        // dd($unit_kerja1->kelahiran_per_desa(null)["lahir_hidup_L"]);
        // foreach (Desa::all() as $key => $value) {
        //     # code...
        //     Neonatal::create([
        //         'desa_id' => $value->id,
        //         'kn1_L' => 0,
        //         'kn1_P' => 0,
        //         'kn_lengkap_L' => 0,
        //         'kn_lengkap_P' => 0,
        //         'hipo_L' => 0,
        //         'hipo_P' => 0,
        //     ]);
        // }
    $unit_kerja = UnitKerja::all();
    $totalLahirHidupL = 0;
    $totalLahirHidupP = 0;
    $totalkn1_L = 0;
    $totalkn1_P = 0;
    $totalkn_lengkap_L = 0;
    $totalkn_lengkap_P = 0;
    $totalhipo_L = 0;
    $totalhipo_P = 0;
    $totalibubersalin = 0;
    $indukOpd = IndukOpd::pluck('nama', 'id');
    // $desa = Desa::first();
    // dd($desa->filterDesa(null));
    if(Auth::user()->roles->first()->name !== "Admin"){
        $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        foreach(Auth::user()->unit_kerja->Desa()->get() as $desa){
            if($desa->filterNeonatal(Session::get('year'))){
                $totalLahirHidupL += $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L;
            $totalLahirHidupP += $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P;
            $totalkn1_L += $desa->filterNeonatal(Session::get('year'))->kn1_L;
            $totalkn1_P += $desa->filterNeonatal(Session::get('year'))->kn1_P;
            $totalkn_lengkap_L += $desa->filterNeonatal(Session::get('year'))->kn_lengkap_L;
            $totalkn_lengkap_P += $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P;
            $totalhipo_L += $desa->filterNeonatal(Session::get('year'))->hipo_L;
            $totalhipo_P += $desa->filterNeonatal(Session::get('year'))->hipo_P;
            }
        }
    } else{
        foreach($unit_kerja as $desa){
            $totalLahirHidupL += $desa->lahir_hidup_L(Session::get('year'));
            $totalLahirHidupP += $desa->lahir_hidup_P(Session::get('year'));
            $totalkn1_L += $desa->kn1_L(Session::get('year'));
            $totalkn1_P += $desa->kn1_P(Session::get('year'));
            $totalkn_lengkap_L += $desa->kn_lengkap_L(Session::get('year'));
            $totalkn_lengkap_P += $desa->kn_lengkap_P(Session::get('year'));
            $totalhipo_L += $desa->hipo_L(Session::get('year'));
            $totalhipo_P += $desa->hipo_P(Session::get('year'));
        }
    }
    $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Neonatal")->first();
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

    // dd(UnitKerja::first()->jumlah_k1);

    $data=[
        'route'=>$this->routeName,
        'title'=>$this->title,
        'induk_opd_arr' => $indukOpd,
        'unit_kerja' =>  $unit_kerja,
        'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
        'totalLahirHidupL' => $totalLahirHidupL,
        'totalLahirHidupP' => $totalLahirHidupP,
        'totalkn1_L' => $totalkn1_L,
        'totalkn1_P' => $totalkn1_P,
        'totalkn_lengkap_L' => $totalkn_lengkap_L,
        'totalkn_lengkap_P' => $totalkn_lengkap_P,
        'totalhipo_L' => $totalhipo_L,
        'totalhipo_P' => $totalhipo_P,
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
        $unitKerja->NeonatalLock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function apiLockUpload(Request $request){

        $user = User::where('id', $request->id)->first();
        $fileUpload = $user->downloadFile('neonatal', Session::get('year'));    
        if(isset($fileUpload)){
            $fileUpload->update([
                'status' => $request->status,
            ]);
        } else {
            fileUpload::create([
                'user_id' => $user->id,
                'menu' => 'neonatal',
                'year' => Session::get('year'),
                'file_name' => '-',
                'file_path' => '-',
                'status' => $request->status,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }
    public function detail_desa(Request $request, $id){

        $unitKerja = UnitKerja::where('id', $id)->first(); 
        $desas = Desa::where('unit_kerja_id', $id)->get();
        $desas->map(function ($desa){
            $desa->lahir_hidup_L = $desa->filterKelahiran(Session::get('year'))->lahir_hidup_L;
            $desa->lahir_hidup_P = $desa->filterKelahiran(Session::get('year'))->lahir_hidup_P;
            $desa->kn1_L = $desa->filterNeonatal(Session::get('year'))->kn1_L;
            $desa->kn1_P = $desa->filterNeonatal(Session::get('year'))->kn1_P;
            $desa->kn_lengkap_L = $desa->filterNeonatal(Session::get('year'))->kn_lengkap_L;
            $desa->kn_lengkap_P = $desa->filterNeonatal(Session::get('year'))->kn_lengkap_P;
            $desa->hipo_L = $desa->filterNeonatal(Session::get('year'))->hipo_L;
            $desa->hipo_P = $desa->filterNeonatal(Session::get('year'))->hipo_P;
            return $desa;
        });

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'desa' => $desas,
        ]);
    }
    public function exportExcel()
    {
        try {
            return Excel::download(new NeonatalExport, 'excel_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function upload(Request $request){
        $user = Auth::user();
        if(!$user->hasFile('neonatal', Session::get('year'))){
            $file=$request->file('file_upload');
            $direktori=public_path().'/storage/image/';          
            $nama_file=str_replace(' ','-',$request->file_upload->getClientOriginalName());
            $file_format= $request->file_upload->getClientOriginalExtension();
            $uploadSuccess = $request->file_upload->move($direktori,$nama_file);

            fileUpload::create([
                'user_id' => $user->id,
                'menu' => 'neonatal',
                'year' => Session::get('year'),
                'file_name' => $nama_file,
                'file_path' => '/storage/image/',
            ]);
        } else {
            $old_file = $user->downloadFile('neonatal', Session::get('year'));
            $file=$request->file('file_upload');
            $direktori=public_path().'/storage/image/';
            File::delete($direktori.$old_file->file_name);          
            $nama_file=str_replace(' ','-',$request->file_upload->getClientOriginalName());
            $file_format= $request->file_upload->getClientOriginalExtension();
            $uploadSuccess = $request->file_upload->move($direktori,$nama_file);
            $old_file->update([
                'file_name' => $nama_file,
                'file_path' => '/storage/image/',
            ]);
        }

        return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil!']);

    }
}
