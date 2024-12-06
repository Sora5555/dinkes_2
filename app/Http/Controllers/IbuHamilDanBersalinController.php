<?php

namespace App\Http\Controllers;

use Session;
use App\Exports\IbuHamilExport;
use App\Models\Desa;
use App\Models\fileUpload;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\IbuHamilDanBersalin;
use App\Models\PengelolaProgram;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class IbuHamilDanBersalinController extends Controller
{
    protected $routeName = 'IbuHamil';
    protected $viewName = 'IbuHamil';
    protected $title = 'IbuHamil';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return NPA::whereHas('kategori',function($query){
        //     $query->where('kategori','Industri Besar');
        // })->get();
        // dd($request->all());

        $unit_kerja = UnitKerja::all();
        $total = 0;
        $totalk1 = 0;
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
                if($desa->filterDesa(Session::get('year'))){
                    $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
                $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
                $totalk4 += $desa->filterSasaranTahunDesa(Session::get('year'))?$desa->filterSasaranTahunDesa(Session::get('year'))->total_capaian():0;
                $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
                $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
                $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
                $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
                $totalvita += $desa->filterDesa(Session::get('year'))->vita;
                $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
                }
            }
        } else{
            foreach($unit_kerja as $desa){
                $total += $desa->jumlah_ibu_hamil(Session::get('year'));
                $totalk1 += $desa->k1(Session::get('year'));
                $totalk4 += $desa->k4(Session::get('year'));
                $totalk6 += $desa->k6(Session::get('year'));
                $totalfasyankes += $desa->fasyankes(Session::get('year'));
                $totalkf1 += $desa->kf1(Session::get('year'));
                $totalkf_lengkap += $desa->kf_lengkap(Session::get('year'));
                $totalvita += $desa->vita(Session::get('year'));
                $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
            }
        }

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' =>  $unit_kerja,
            'desa' => Auth::user()->unit_kerja?Auth::user()->unit_kerja->Desa()->get():Desa::all(),
            'total_ibu_hamil' => $total,
            'total_k1' => $totalk1,
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

    $fillable = (new IbuHamilDanBersalin())->getFillable();
    foreach (Auth::user()->unit_kerja->Desa()->get() as $desa) {
        if ($desa->filterDesa(Session::get('year'))) {
            continue;
        } else {
            $data = ['desa_id' => $desa->id]; // Include the `desa_id` field
            foreach ($fillable as $field) {
                $data[$field] = $field === 'desa_id' ? $desa->id : 0; // Set default values dynamically
            }
            IbuHamilDanBersalin::create($data);
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
        //
        try {
            $IbuHamil = IbuHamilDanBersalin::where('id', $request->id)->first();
           
            $jumlah_ibu_hamil = $IbuHamil->jumlah_ibu_hamil;
            $jumlah_ibu_bersalin = $IbuHamil->jumlah_ibu_bersalin;
            $IbuHamil->update([
                $request->name => $request->value,
            ]);
            $desa = $IbuHamil->Desa->UnitKerja;
            $total = 0;
            $total_ibu_hamil = 0;
            $total_ibu_bersalin = 0;
            $percentage = 0;

            foreach ($desa->desa as $key => $value) {
                # code...
                // dd($value->filterDesa(Session::get('year')), Session::get('year'));
                $total_ibu_hamil += $value->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
                $total_ibu_bersalin += $value->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
                $total += $value->filterDesa(Session::get('year'))->{$request->name};
            }
            if($request->name == "k1" || $request->name == "k4"  || $request->name == "k6"){
                $percentage = $total_ibu_hamil > 0?number_format($total/$total_ibu_hamil * 100, 2):0;
            } else {
               $percentage =  $total_ibu_bersalin > 0?number_format($total/$total_ibu_bersalin * 100, 2):0;
            }
            // dd(($IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, $IbuHamil->fasyankes, $jumlah_ibu_bersalin, gettype($IbuHamil->fasyankes));
            return response()->json([
                'status' => 'success',
                'k1' => $jumlah_ibu_hamil > 0?number_format($IbuHamil->k1/$jumlah_ibu_hamil * 100, 2):0,
                'k4' => $jumlah_ibu_hamil > 0?number_format($IbuHamil->k4/$jumlah_ibu_hamil * 100, 2):0,
                'k6' => $jumlah_ibu_hamil > 0?number_format($IbuHamil->k6/$jumlah_ibu_hamil * 100, 2):0,
                'fasyankes' => $jumlah_ibu_bersalin > 0?number_format(((int)$IbuHamil->fasyankes/$jumlah_ibu_bersalin) * 100, 2):0,
                'kf1' => $jumlah_ibu_bersalin > 0?number_format(((int)$IbuHamil->kf1/$jumlah_ibu_bersalin) * 100, 2):0,
                'kf_lengkap' => $jumlah_ibu_bersalin > 0?number_format(((int)$IbuHamil->kf_lengkap/$jumlah_ibu_bersalin) * 100, 2):0,
                'vita' => $jumlah_ibu_bersalin > 0?number_format(((int)$IbuHamil->vita/$jumlah_ibu_bersalin) * 100, 2):0,
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
        $IbuHamil = IbuHamilDanBersalin::where('desa_id', $id)->first();
        try {
            $IbuHamil->update($request->all());
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
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
        // dd("A");
        $unit_kerja = UnitKerja::all();
        $total = 0;
        $totalk1 = 0;
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
                if($desa->filterDesa(Session::get('year'))){
                    $total += $desa->filterDesa(Session::get('year'))->jumlah_ibu_hamil;
                $totalk1 += $desa->filterDesa(Session::get('year'))->k1;
                $totalk4 += $desa->filterSasaranTahunDesa(Session::get('year'))?$desa->filterSasaranTahunDesa(Session::get('year'))->total_capaian():0;
                $totalk6 += $desa->filterDesa(Session::get('year'))->k6;
                $totalfasyankes += $desa->filterDesa(Session::get('year'))->fasyankes;
                $totalkf1 += $desa->filterDesa(Session::get('year'))->kf1;
                $totalkf_lengkap += $desa->filterDesa(Session::get('year'))->kf_lengkap;
                $totalvita += $desa->filterDesa(Session::get('year'))->vita;
                $totalibubersalin += $desa->filterDesa(Session::get('year'))->jumlah_ibu_bersalin;
                }
            }
        } else{
            foreach($unit_kerja as $desa){
                $total += $desa->jumlah_ibu_hamil(Session::get('year'));
                $totalk1 += $desa->k1(Session::get('year'));
                $totalk4 += $desa->k4(Session::get('year'));
                $totalk6 += $desa->k6(Session::get('year'));
                $totalfasyankes += $desa->fasyankes(Session::get('year'));
                $totalkf1 += $desa->kf1(Session::get('year'));
                $totalkf_lengkap += $desa->kf_lengkap(Session::get('year'));
                $totalvita += $desa->vita(Session::get('year'));
                $totalibubersalin += $desa->jumlah_ibu_bersalin(Session::get('year'));
            }
        }

        // dd(UnitKerja::first()->jumlah_k1);
        $pengelola_program = PengelolaProgram::where('user_id', Auth::user()->id)->where("program", "Ibu Hamil Dan Bersalin")->first();
        $nama_pengelola = "";
        $nip_pengelola = "";
        $tahun = 0;
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
            'total_ibu_hamil' => $total,
            'total_k1' => $totalk1,
            'total_k4' => $totalk4,
            'total_k6' => $totalk6,
            'total_fasyankes' => $totalfasyankes,
            'total_kf1' => $totalkf1,
            'total_kf_lengkap' => $totalkf_lengkap,
            'total_vita' => $totalvita,
            'total_ibu_bersalin' => $totalibubersalin,
            'nama_pengelola' => $nama_pengelola,
            'nip_pengelola' => $nip_pengelola,
            'tahun' => $tahun,
            // 'jabatan' => Jabatan::get(),
            // 'jenis_jabatan' => JenisJabatan::pluck('nama', 'id'),
            // 'unit_organisasi' => UnitOrganisasi::get()
        ];

        return view($this->viewName.'.report')->with($data);
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();
        $IbuHamil = IbuHamilDanBersalin::where('desa_id', $id)->first();

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
            'IbuHamil' => $IbuHamil,
        ]);
    }
    public function apiLock(Request $request){

        $unitKerja = UnitKerja::where('id', $request->id)->first();    
        $unitKerja->lock(Session::get('year'), $request->status);   

        return response()->json([
            'status' => 'success',
            'data' => $unitKerja,
        ]);
    }
    public function detail_desa(Request $request, $id, $secondaryFilter = null)
{
    $unitKerja = UnitKerja::find($id); // Retrieve the unit kerja
    $desas = Desa::where('unit_kerja_id', $id)->get();

    $year = Session::get('year');
    $mainFilter = $request->input('mainFilter');
    $secondaryFilter = $request->input('secondaryFilter');

    // Dynamically apply the filters based on the provided filter names
    $desas->map(function ($desa) use ($mainFilter, $secondaryFilter, $year) {
        // Apply the main filter
        if (method_exists($desa, $mainFilter)) {
            $mainFilteredData = $desa->{$mainFilter}($year);

            if ($mainFilteredData) {
                // Automatically assign all attributes returned by the main filter
                foreach ($mainFilteredData->toArray() as $key => $value) {
                    $desa->{$key} = $value;
                }
            }
        }

        // Apply the optional secondary filter
        if ($secondaryFilter && method_exists($desa, $secondaryFilter)) {
            $secondaryFilteredData = $desa->{$secondaryFilter}($year);

            if ($secondaryFilteredData) {
                // Automatically assign all attributes returned by the secondary filter
                foreach ($secondaryFilteredData->toArray() as $key => $value) {
                    $desa->{$key} = $value;
                }
            }
        }

        return $desa;
    });

    return response()->json([
        'status' => 'success',
        'data' => $unitKerja,
        'desa' => $desas,
    ]);
}
public function upload(Request $request){
    $user = Auth::user();
    if(!$user->hasFile('IbuHamil', Session::get('year'))){
        $file=$request->file('file_upload');
        $direktori=public_path().'/storage/image/';          
        $nama_file=str_replace(' ','-',$request->file_upload->getClientOriginalName());
        $file_format= $request->file_upload->getClientOriginalExtension();
        $uploadSuccess = $request->file_upload->move($direktori,$nama_file);

        fileUpload::create([
            'user_id' => $user->id,
            'menu' => 'IbuHamil',
            'year' => Session::get('year'),
            'file_name' => $nama_file,
            'file_path' => '/storage/image/',
            'status' => 0,
        ]);
    } else {
        $old_file = $user->downloadFile('IbuHamil', Session::get('year'));
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
public function apiLockUpload(Request $request){

    $user = User::where('id', $request->id)->first();
    $fileUpload = $user->downloadFile('IbuHamil', Session::get('year'));    
    if(isset($fileUpload)){
        $fileUpload->update([
            'status' => $request->status,
        ]);
    } else {
        fileUpload::create([
            'user_id' => $user->id,
            'menu' => 'IbuHamil',
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
public function exportExcel()
    {
        try {
            return Excel::download(new IbuHamilExport, 'Ibu_Hamil_report.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
