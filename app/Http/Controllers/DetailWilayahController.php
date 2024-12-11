<?php

namespace App\Http\Controllers;

use App\Exports\DetailWilayahExport;
use App\Models\IndukOpd;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class DetailWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'DetailWilayah';
    protected $viewName = 'detail_wilayah';
    protected $title = 'Detail Wilayah';
    public function index(Request $request)
    {

        $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();
        $total_luas_wilayah = 0;
        $total_desa = 0;
        $total_kelurahan = 0;
        $total_jumlah_penduduk = 0;
        $total_jumlah_rumah_tangga = 0;

        $indukOpd = IndukOpd::pluck('nama', 'id');
            foreach($unit_kerja as $puskesmas){
                $total_luas_wilayah += $puskesmas->luas_wilayah;
                $total_desa += $puskesmas->Desa()->count();
                $total_kelurahan += $puskesmas->kelurahan;
                $total_jumlah_penduduk += $puskesmas->jumlah_penduduk;
                $total_jumlah_rumah_tangga += $puskesmas->jumlah_rumah_tangga;
            }

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'induk_opd_arr' => $indukOpd,
            'unit_kerja' =>  $unit_kerja,
            'total_luas_wilayah' => $total_luas_wilayah,
            'total_desa' => $total_desa,
            'total_kelurahan' => $total_kelurahan,
            'total_jumlah_penduduk' => $total_jumlah_penduduk,
            'total_jumlah_rumah_tangga' => $total_jumlah_rumah_tangga,
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
        $unit_kerja = UnitKerja::where("id", $request->id)->first();
        $unit_kerja->update([
            $request->name => $request->value,
        ]);
        $desaKelurahan = $unit_kerja->kelurahan + $unit_kerja->Desa()->count();
        $rata_rata_rumah_tangga = $unit_kerja->jumlah_rumah_tangga > 0?(number_format($unit_kerja->jumlah_penduduk/$unit_kerja->jumlah_rumah_tangga * 100)):0;
        $kepadatanPenduduk = $unit_kerja->luas_wilayah > 0?(number_format($unit_kerja->jumlah_penduduk/$unit_kerja->luas_wilayah * 100)):0;
        return response()->json([
            'status' => 'success',
            'desaKelurahan' => $desaKelurahan,
            'rata_rata_rumah_tangga' => $rata_rata_rumah_tangga,
            'kepadatanPenduduk' => $request->kepadatanPenduduk,
        ]);
    }

    public function export() {
        try {
            return Excel::download(new DetailWilayahExport, 'detail_wilayah_report_'.Session::get('year').'.xlsx');
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
                        // dd($data);
        foreach ($data as $key => $row) {
            if($key == 0 || $key == 1){
                continue;
            } else {

                $indukOPD = IndukOpd::where('nama', 'LIKE', '%'.$row[1].'%')->first();

                if($indukOPD) {

                    $UnitKerjaExist = UnitKerja::where('induk_opd_id', $indukOPD->id)->whereYear('created_at', Session::get('year'))->first();
                    if($UnitKerjaExist) {
                        $UnitKerjaAdd = UnitKerja::find($UnitKerjaExist->id);
                    } else {
                        $UnitKerjaAdd = new UnitKerja;
                    }

                    $UnitKerjaAdd->induk_opd_id = $indukOPD->id;
                    $UnitKerjaAdd->kecamatan = "null";
                    $UnitKerjaAdd->nama = $row[1];
                    $UnitKerjaAdd->tipe = "Puskesmas";
                    $UnitKerjaAdd->luas_wilayah = $row[2];
                    $UnitKerjaAdd->kelurahan = $row[3];
                    $UnitKerjaAdd->jumlah_penduduk = $row[4];
                    $UnitKerjaAdd->jumlah_rumah_tangga = $row[5];
                    $UnitKerjaAdd->save();
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
