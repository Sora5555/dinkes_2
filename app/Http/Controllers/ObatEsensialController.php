<?php

namespace App\Http\Controllers;

use App\Models\IndukOpd;
use App\Models\ObatEsensial;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ObatEsensialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'ObatEsensial';
    protected $viewName = 'obat_esensial';
    protected $title = 'Obat Esensial';
    public function index(Request $request)
    {

        $unit_kerja = UnitKerja::whereYear('created_at', Session::get('year'))->get();
        $obat_tersedia = UnitKerja::whereRelation('ObatEsensial', 'status', 1)->whereYear('created_at', Session::get('year'))->count();
        $total_obat = UnitKerja::whereHas('ObatEsensial', function($query) {
            $query->where('status', '!=', 0);
        })->whereYear('created_at', Session::get('year'))->count();

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'unit_kerja' =>  $unit_kerja,
            'obat_tersedia' => $obat_tersedia,
            'total_obat' => $total_obat,
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
        $unit_kerja = UnitKerja::where('id', $request->id)->first();
        $err = "";
        if($request->name == "diatas_80" && $unit_kerja->ObatEsensial->status == 0){
            $unit_kerja->ObatEsensial->update([
                'status' => 1,
            ]);
        } else if($request->name == "diatas_80" && $unit_kerja->ObatEsensial->status == 1){
            $unit_kerja->ObatEsensial->update([
                'status' => 0,
            ]);
        } else if($request->name == "dibawah_80" && $unit_kerja->ObatEsensial->status == 0){
            $unit_kerja->ObatEsensial->update([
                'status' => 2,
            ]);
        } else if($request->name == "dibawah_80" && $unit_kerja->ObatEsensial->status == 2){
            $unit_kerja->ObatEsensial->update([
                'status' => 0,
            ]);
        } else {
            $err = "Hanya Satu kondisi yang boleh di tentukan";
        }

        return response()->json([
            'status' => 'success',
            'err' => $err,
        ]);
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

                $UnitKerja = UnitKerja::where('nama', 'LIKE', '%'.$row[1].'%')->first();

                if($UnitKerja) {
                    // dd($row);
                    $ObatEsensialExist = ObatEsensial::where('unit_kerja_id', $UnitKerja->id)->whereYear('created_at', Session::get('year'))->first();
                    // dd($ObatEsensialExist);
                    if($ObatEsensialExist) {
                        $ObatEsensialStore = ObatEsensial::find($ObatEsensialExist->id);
                    } else {
                        $ObatEsensialStore = new ObatEsensial;
                    }

                    $ObatEsensialStore->unit_kerja_id = $UnitKerja->id;
                    $ObatEsensialStore->status = $row[2];
                    $ObatEsensialStore->save();
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
