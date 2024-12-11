<?php

namespace App\Http\Controllers;

use App\Exports\UnitOrganisasiExport;
use App\Models\Desa;
use Session,DB;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Eselon;
use App\Models\IndukOpd;
use App\Models\KategoriNPA;
use App\Models\TenagaGizi;
use App\Models\TenagaKesehatanLingkungan;
use App\Models\TenagaKesehatanMasyarakat;
use App\Models\TenagaTeknikBiomedik;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Models\UnitOrganisasi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UnitOrganisasiController extends Controller
{
    protected $routeName = 'unit_organisasi';
    protected $viewName = 'unit_organisasi';
    protected $title = 'Unit Organisasi';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $indukOpd = IndukOpd::pluck('nama', 'id');
        if(Auth::user()->roles->first()->name !== "Admin"){
            $indukOpd = IndukOpd::where('id', Auth::user()->induk_opd_id)->pluck('nama', 'id');
        }
        $unit_kerja = UnitKerja::where('id', Auth::user()->unit_kerja_id)->get();
        if(Auth::user()->roles->first()->name == "Admin"){
            $unit_kerja = UnitKerja::get();
        }
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' => $unit_kerja,
            // 'eselon_arr' =>Eselon::pluck('nama', 'id')
        ];
        return view($this->routeName.'.index')->with($data);
    }

    public function datatable(Request $request){

        $datas = UnitOrganisasi::where('induk_opd_id', $request->induk_opd)->get();

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
            })
            ->editColumn('eselon',function($data){
                return $data->eselon->nama;
            })
            ->addColumn('action', function ($data) {
                $route = 'unit_organisasi';
                return view('layouts.includes.table-action',compact('data','route'));
            });

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'route'=>$this->routeName,
            'title'=>$this->title,
        ];
        return view($this->routeName.'.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'kategori'=>'required',
        // ],[
        //     'kategori.required'=>'kategori tidak boleh kosong',
        // ]);
        DB::beginTransaction();
        try {
            UnitOrganisasi::create($request->all());
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Menambah Data Unit Organisasi"
            ]);
            DB::commit();
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Unit Organisasi: '.$request->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal Menambah data Unit Organisasi : '.$e->getMessage()])->withErrors($request->nama)->withInput($request->all());
        }
    }

    public function export() {
        try {
            return Excel::download(new UnitOrganisasiExport, 'unit_organisasi_report_'.Session::get('year').'.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
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



            $unit_kerja = UnitKerja::where('nama', 'LIKE', '%'. $row[1] .'%' )->first();

            if($unit_kerja) {
                $desa = Desa::where('nama', 'LIKE', '%'. $row[2] .'%')->first();
                if($desa) {
                    $TenagaKesehatanMasyarakatExist = TenagaKesehatanMasyarakat::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($TenagaKesehatanMasyarakatExist) {
                        $TenagaKesehatanMasyarakatUpdate = TenagaKesehatanMasyarakat::find($TenagaKesehatanMasyarakatExist->id);
                        $TenagaKesehatanMasyarakatUpdate->laki_laki = $row[3];
                        $TenagaKesehatanMasyarakatUpdate->perempuan = $row[4];
                        $TenagaKesehatanMasyarakatUpdate->save();
                    } else {
                        $TenagaKesehatanMasyarakatAdd = new TenagaKesehatanMasyarakat;
                        $TenagaKesehatanMasyarakatAdd->unit_kerja_id = $unit_kerja->id;
                        $TenagaKesehatanMasyarakatAdd->desa_id = $desa->id;
                        $TenagaKesehatanMasyarakatAdd->laki_laki = $row[3];
                        $TenagaKesehatanMasyarakatAdd->perempuan = $row[4];
                        $TenagaKesehatanMasyarakatAdd->save();
                    }


                    $TenagaKesehatanLingkunganExist = TenagaKesehatanLingkungan::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($TenagaKesehatanLingkunganExist) {
                        $TenagaKesehatanLingkunganUpdate = TenagaKesehatanLingkungan::find($TenagaKesehatanLingkunganExist->id);
                        $TenagaKesehatanLingkunganUpdate->laki_laki = $row[6];
                        $TenagaKesehatanLingkunganUpdate->perempuan = $row[7];
                        $TenagaKesehatanLingkunganUpdate->save();
                    } else {
                        $TenagaKesehatanLingkunganAdd = new TenagaKesehatanLingkungan;
                        $TenagaKesehatanLingkunganAdd->unit_kerja_id = $unit_kerja->id;
                        $TenagaKesehatanLingkunganAdd->desa_id = $desa->id;
                        $TenagaKesehatanLingkunganAdd->laki_laki = $row[6];
                        $TenagaKesehatanLingkunganAdd->perempuan = $row[7];
                        $TenagaKesehatanLingkunganAdd->save();
                    }

                    $TenagaGiziExist = TenagaGizi::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    if($TenagaGiziExist) {
                        $TenagaGiziUpdate = TenagaGizi::find($TenagaGiziExist->id);
                        $TenagaGiziUpdate->laki_laki = $row[9];
                        $TenagaGiziUpdate->perempuan = $row[10];
                        $TenagaGiziUpdate->save();
                    } else {
                        $TenagaGiziAdd = new TenagaGizi;
                        $TenagaGiziAdd->unit_kerja_id = $unit_kerja->id;
                        $TenagaGiziAdd->desa_id = $desa->id;
                        $TenagaGiziAdd->laki_laki = $row[9];
                        $TenagaGiziAdd->perempuan = $row[10];
                        $TenagaGiziAdd->save();
                    }

                    // $KeteknisanMedikExist = KeteknisanMedik::where('unit_kerja_id', $unit_kerja->id)->where('desa_id', $desa->id)->whereYear('created_at', Session::get('year'))->first();
                    // if($KeteknisanMedikExist) {
                    //     $KeteknisanMedikUpdate = KeteknisanMedik::find($KeteknisanMedikExist->id);
                    //     $KeteknisanMedikUpdate->laki_laki = $row[12];
                    //     $KeteknisanMedikUpdate->perempuan = $row[13];
                    //     $KeteknisanMedikUpdate->save();
                    // } else {
                    //     $KeteknisanMedikAdd = new KeteknisanMedik;
                    //     $KeteknisanMedikAdd->unit_kerja_id = $unit_kerja->id;
                    //     $KeteknisanMedikAdd->desa_id = $desa->id;
                    //     $KeteknisanMedikAdd->laki_laki = $row[12];
                    //     $KeteknisanMedikAdd->perempuan = $row[13];
                    //     $KeteknisanMedikAdd->save();
                    // }
                }

            }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $desa = Desa::with('TenagaKesehatanMasyarakat', 'TenagaKesehatanLingkungan', 'TenagaGizi')->where('unit_kerja_id',$id)->get();

        return response()->json($desa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=[
            'UnitOrganisasi'=>UnitOrganisasi::findOrFail($id),
            'route'=>$this->routeName,
            'title'=>$this->title,
            'eselon_arr' => Eselon::pluck('nama', 'id'),
        ];
        return view($this->viewName.'.edit')->with($data);
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

        // dd($request->all());
        DB::beginTransaction();
        try {
            $unitKerja = UnitKerja::where('id', $id)->first();
            $kesehatanMasyarakat = TenagaKesehatanMasyarakat::where('unit_kerja_id', $id)->first();
            $tenagaGizi = TenagaGizi::where('unit_kerja_id', $id)->first();
            $kesehatanLingkungan = TenagaKesehatanLingkungan::where('unit_kerja_id', $id)->first();
            $kesehatanMasyarakat->update([
                'laki_laki' => $request->kesehatanMasyarakatLakiLaki,
                'perempuan' => $request->kesehatanMasyarakatPerempuan,
            ]);
            $tenagaGizi->update([
                'laki_laki' => $request->tenagaGiziLakiLaki,
                'perempuan' => $request->tenagaGiziPerempuan,
            ]);
            $kesehatanLingkungan->update([
                'laki_laki' => $request->kesehatanLingkunganLakiLaki,
                'perempuan' => $request->kesehatanLingkunganPerempuan,
            ]);
            DB::commit();
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil mengubah Data Unit Organisasi: '.$request->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal mengubah Data Unit Organisasi : '.$e->getMessage()])->withErrors($request->nama)->withInput($request->all());
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
        try {
            $kategori = UnitOrganisasi::findOrFail($id);
            $kategori->delete();
            Log::create([
                'pengguna' => Auth::user()->nama,
                'kegiatan' => "Hapus Data Unit Organisasi"
            ]);
            return redirect()->back()->with(['success'=>'Berhasil menghapus Data Unit Organisasi : '.$kategori->nama]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error'=>'Gagal menghapus Data Unit Organisasi : '.$e->getMessage()])->withErrors($kategori->kategori);
        }
    }
    public function apiEdit($id){

        $unitKerja = UnitKerja::where('id', $id)->first();

        $kesehatanMasyarakat = TenagaKesehatanMasyarakat::where('unit_kerja_id', $id)->first();
        $tenagaGizi = TenagaGizi::where('unit_kerja_id', $id)->first();
        $kesehatanLingkungan = TenagaKesehatanLingkungan::where('unit_kerja_id', $id)->first();

         return response()->json([
             'status' => 'success',
             'data' => $unitKerja,
             'kesehatanMasyarakat' => $kesehatanMasyarakat,
             'tenagaGizi' => $tenagaGizi,
             'kesehatanLingkungan' => $kesehatanLingkungan,
         ]);
     }
}
