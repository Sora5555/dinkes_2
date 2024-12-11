<?php

namespace App\Http\Controllers;

use App\Exports\VaksinExport;
use App\Models\Vaksin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class VaksinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'Vaksin';
    protected $viewName = 'vaksin';
    protected $title = 'Vaksin';
    public function index(Request $request)
    {

        $vaksin = Vaksin::whereYear('created_at', Session::get('year'))->get();
        $vaksin_tersedia = Vaksin::where('status', 1)->whereYear('created_at', Session::get('year'))->count();
        $total_vaksin = Vaksin::whereYear('created_at', Session::get('year'))->count();

        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'vaksin' =>  $vaksin,
            'vaksin_tersedia' => $vaksin_tersedia,
            'total_vaksin' => $total_vaksin,
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
        $vaksin = Vaksin::where('id', $request->id)->first();
        $err = "";
        if($request->name == "diatas_80" && $vaksin->status == 0){
            $vaksin->update([
                'status' => 1,
            ]);
        } else if($request->name == "diatas_80" && $vaksin->status == 1){
            $vaksin->update([
                'status' => 0,
            ]);
        } else if($request->name == "dibawah_80" && $vaksin->status == 0){
            $vaksin->update([
                'status' => 2,
            ]);
        } else if($request->name == "dibawah_80" && $vaksin->status == 2){
            $vaksin->update([
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

                $VaksinOne = Vaksin::where('nama_vaksin', 'LIKE', '%'.$row[1].'%')->whereYear('created_at', Session::get('year'))->first();
                if($VaksinOne) {
                    $VaksinAdd = Vaksin::find($VaksinOne->id);
                } else {
                    $VaksinAdd = new Vaksin;
                }
                $VaksinAdd->nama_vaksin = $row[1];
                $VaksinAdd->satuan = $row[2];
                $VaksinAdd->status = $row[3];


                $VaksinAdd->save();

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
            return Excel::download(new VaksinExport, 'vaksin_report_'.Session::get('year').'.xlsx');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
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
    public function VaksinNew(Request $request)
    {
        try {
            Vaksin::create($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Vaksin']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->routeName.'.index')->with(['failure'=>$th->getMessage()]);
        }
        //
    }
}
