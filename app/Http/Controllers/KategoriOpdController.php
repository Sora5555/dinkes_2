<?php

namespace App\Http\Controllers;

use App\Exports\KategoriOPDExport;
use App\Models\AhliLabMedik;
use App\Models\Desa;
use App\Models\kategoriOpd;
use App\Models\KeteknisanMedik;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Role;
use App\Models\TenagaTeknikBiomedik;
use App\Models\TerapiFisik;
use App\Models\UnitKerja;
use App\Models\User;
use App\Models\UptDaerah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class KategoriOpdController extends Controller
{
    protected $routeName = 'kategori_opd';
    protected $viewName = 'kategori_opd';
    protected $title = 'Kategori OPD';

    public function index()
    {
        // whereYear('created_at', Session::get('year'))
        $route = $this->routeName;
        $title = $this->title;
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::get();
        }


        return view($this->viewName.'.index',compact('route','title', 'unit_kerja'));
    }

    public function datatable()
    {
        $datas = kategoriOpd::get();

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($data) {
                $route = 'kategori_opd';
                return view('layouts.includes.table-action',compact('data','route'));
            });

        return $datatables->make(true);
    }

    public function create(Request $request)
    {
        $route = $this->routeName;
        $title = $this->title;

        return view($this->viewName.'.create',compact('route','title'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        try{

            // $role = Role::where('nama_role','UPT. Daerah')->first();

            $query1 = kategoriOpd::create($request->all());

            // $query = User::create([
            //     'name' => $request->nama_daerah,
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            //     'upt_daerah_id' => $query1->id,
            //     'role_id' => $role->id
            // ]);

            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Kategori OPD"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Data Kategori OPD : '.$query1->nama]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menambah Data Upt Daerah : '.$e->getMessage()])->withErrors($request->all())->withInput($request->all());
        }

    }

    public function import(Request $request)
{
    $file = $request->file('excel_file');
    function check_internet_connection() {
        return @fsockopen("www.google.com", 80); // Open a connection to google.com on port 80 (HTTP) - Change the domain if needed
    }
    // dd($request->all());

    $data = Excel::toArray([], $file, null, \Maatwebsite\Excel\Excel::XLSX)[0];
    DB::BeginTransaction();
    foreach ($data as $key => $row) {
        if($key == 0 || $key == 1){
            continue;
        } else {
            // dd($row);

            // <td>{{$item->AhliLabMedik->sum("laki_laki")}}</td>
            // <td>{{$item->AhliLabMedik->sum("perempuan")}}</td>
            // <td>{{$item->AhliLabMedik->sum("laki_laki") + $item->AhliLabMedik->sum("perempuan")}}</td>
            // <td>{{$item->TenagaTeknikBiomedik->sum("laki_laki")}}</td>
            // <td>{{$item->TenagaTeknikBiomedik->sum("perempuan")}}</td>
            // <td>{{$item->TenagaTeknikBiomedik->sum("laki_laki") + $item->TenagaTeknikBiomedik->sum("perempuan")}}</td>
            // <td>{{$item->TerapiFisik->sum("laki_laki")}}</td>
            // <td>{{$item->TerapiFisik->sum("perempuan")}}</td>
            // <td>{{$item->TerapiFisik->sum("laki_laki") + $item->TerapiFisik->sum("perempuan")}}</td>
            // <td>{{$item->KeteknisanMedik->sum("laki_laki")}}</td>
            // <td>{{$item->KeteknisanMedik->sum("perempuan")}}</td>
            // <td>{{$item->KeteknisanMedik->sum("laki_laki") + $item->KeteknisanMedik->sum("perempuan")}}</td>

            $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

            if($unit_kerja) {
                $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                if($desa) {
                    $AhliLabMedikExist = AhliLabMedik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($AhliLabMedikExist) {
                        $AhliLabMedikUpdate = AhliLabMedik::find($AhliLabMedikExist->id);
                        $AhliLabMedikUpdate->laki_laki = $row[3];
                        $AhliLabMedikUpdate->perempuan = $row[4];
                        $AhliLabMedikUpdate->save();
                    } else {
                        $AhliLabMedikAdd = new AhliLabMedik;
                        $AhliLabMedikAdd->unit_kerja_id = $unit_kerja->id;
                        $AhliLabMedikAdd->desa_id = $desa->id;
                        $AhliLabMedikAdd->laki_laki = $row[3];
                        $AhliLabMedikAdd->perempuan = $row[4];
                        $AhliLabMedikAdd->save();
                    }


                    $TenagaTeknikBiomedikExist = TenagaTeknikBiomedik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($TenagaTeknikBiomedikExist) {
                        $TenagaTeknikBiomedikUpdate = TenagaTeknikBiomedik::find($TenagaTeknikBiomedikExist->id);
                        $TenagaTeknikBiomedikUpdate->laki_laki = $row[6];
                        $TenagaTeknikBiomedikUpdate->perempuan = $row[7];
                        $TenagaTeknikBiomedikUpdate->save();
                    } else {
                        $TenagaTeknikBiomedikAdd = new TenagaTeknikBiomedik;
                        $TenagaTeknikBiomedikAdd->unit_kerja_id = $unit_kerja->id;
                        $TenagaTeknikBiomedikAdd->desa_id = $desa->id;
                        $TenagaTeknikBiomedikAdd->laki_laki = $row[6];
                        $TenagaTeknikBiomedikAdd->perempuan = $row[7];
                        $TenagaTeknikBiomedikAdd->save();
                    }

                    $TerapiFisikExist = TerapiFisik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($TerapiFisikExist) {
                        $TerapiFisikUpdate = TerapiFisik::find($TerapiFisikExist->id);
                        $TerapiFisikUpdate->laki_laki = $row[9];
                        $TerapiFisikUpdate->perempuan = $row[10];
                        $TerapiFisikUpdate->save();
                    } else {
                        $TerapiFisikAdd = new TerapiFisik;
                        $TerapiFisikAdd->unit_kerja_id = $unit_kerja->id;
                        $TerapiFisikAdd->desa_id = $desa->id;
                        $TerapiFisikAdd->laki_laki = $row[9];
                        $TerapiFisikAdd->perempuan = $row[10];
                        $TerapiFisikAdd->save();
                    }

                    $KeteknisanMedikExist = KeteknisanMedik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($KeteknisanMedikExist) {
                        $KeteknisanMedikUpdate = KeteknisanMedik::find($KeteknisanMedikExist->id);
                        $KeteknisanMedikUpdate->laki_laki = $row[12];
                        $KeteknisanMedikUpdate->perempuan = $row[13];
                        $KeteknisanMedikUpdate->save();
                    } else {
                        $KeteknisanMedikAdd = new KeteknisanMedik;
                        $KeteknisanMedikAdd->unit_kerja_id = $unit_kerja->id;
                        $KeteknisanMedikAdd->desa_id = $desa->id;
                        $KeteknisanMedikAdd->laki_laki = $row[12];
                        $KeteknisanMedikAdd->perempuan = $row[13];
                        $KeteknisanMedikAdd->save();
                    }
                }

            }

            // $AhliLabMedikExist = AhliLabMedik


            // $sasaran_backup = SasaranTahunIbuHamil::where('desa_id', $desa->id)->first();

            // setlocale(LC_TIME, 'id_ID');
            // $timestamp = Carbon::now()->format('F');
            // if($sasaran_backup){
            //     $array_backup = $sasaran_backup->toArray();
            //     $array_backup_fix = collect($array_backup)->except(['created_at', 'updated_at', 'deleted_at'])->toArray();
            //     // dd($array_backup_fix);
            //     BackupSasaranTahunIbuHamil::create($array_backup_fix);
            //     $sasaran_backup->update([
            //         "sasaran_jumlah_ibu_hamil" => $row[2],
            //         'sasaran_april' => 0,
            //         'status_april' => 0,
            //         'capaian_april' => 0,
            //     ]);
            //     // if($key == 2){
            //     //     dd($monthNames[$timestamp], $sasaran_backup);
            //     // }
            // }
            setlocale(LC_TIME, 0);
        }
        if (!check_internet_connection()) {
            DB::rollBack(); // Rollback the transaction
            return redirect()->back()->with('error', 'Koneksi Hilang saat proses import data');
        }
    }
    DB::commit();

    return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menambah Sasaran']);
}

    public function export() {
        try {
            return Excel::download(new KategoriOPDExport, 'kategori_opd_report_'.Session::get('year').'.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function show($id)
    {
        //
        $desa = Desa::with('AhliLabMedik', 'TenagaTeknikBiomedik', 'TerapiFisik', 'KeteknisanMedik')->where('unit_kerja_id',$id)->get();

        return response()->json($desa);

    }

    public function edit($id)
    {
        $data = [
            'kategori_opd'=>kategoriOpd::findOrFail($id),
            'title'=>$this->title,
            'route'=>$this->routeName,
        ];
        return view($this->viewName.'.edit')->with($data);
    }

    public function update(Request $request, $id)
    {

        $unitKerja = UnitKerja::where('id', $id)->first();

        $teknisBiomedika = TenagaTeknikBiomedik::where('unit_kerja_id', $id)->first();
        $terapiFisik = TerapiFisik::where('unit_kerja_id', $id)->first();
        $labMedik = AhliLabMedik::where('unit_kerja_id', $id)->first();
        $keteknisanMedik = KeteknisanMedik::where("unit_kerja_id", $id)->first();


        try{

            $teknisBiomedika->update([
                'laki_laki' => $request->teknisBiomedikaLakiLaki,
                'perempuan' => $request->teknisBiomedikaPerempuan,
            ]);
            $labMedik->update([
                'laki_laki' => $request->labMedikLakiLaki,
                'perempuan' => $request->labMedikPerempuan,
            ]);
            $terapiFisik->update([
                'laki_laki' => $request->terapiFisikLakiLaki,
                'perempuan' => $request->terapiFisikPerempuan,
            ]);
            $keteknisanMedik->update([
                'laki_laki' => $request->keteknisanMedikLakiLaki,
                'perempuan' => $request->keteknisanMedikPerempuan,
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengubah Data Kategori OPD : '.$request->nama]);
        } catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Mengubah Data Kategori OPD : '.$e->getMessage()])->withErrors($request->all())->withInput($request->all());
        }
    }

    public function destroy(Request $request,$id)
    {
        try {
            $kategori_opd = kategoriOpd::findOrFail($id);
            $kategori_opd->delete();
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Kategori OPD"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Kategori OPD : '.$kategori_opd->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Kategori OPD : '.$e->getMessage()])->withErrors($request->all());
        }
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();

        $teknisBiomedika = TenagaTeknikBiomedik::where('unit_kerja_id', $id)->first();
        $terapiFisik = TerapiFisik::where('unit_kerja_id', $id)->first();
        $labMedik = AhliLabMedik::where('unit_kerja_id', $id)->first();
        $keteknisanMedik = KeteknisanMedik::where('unit_kerja_id', $id)->first();

         return response()->json([
             'status' => 'success',
             'data' => $unitKerja,
             'teknisBiomedika' => $teknisBiomedika,
             'terapiFisik' => $terapiFisik,
             'labMedik' => $labMedik,
             'keteknisanMedik' => $keteknisanMedik,
         ]);
     }
}
