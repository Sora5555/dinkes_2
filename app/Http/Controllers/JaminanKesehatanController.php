<?php

namespace App\Http\Controllers;

use App\Models\JaminanKesehatan;
use App\Models\JumlahPenduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class JaminanKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'JaminanKesehatan';
    protected $viewName = 'jaminan_kesehatan';
    protected $title = 'Jaminan Kesehatan';
    public function index(Request $request)
    {

        $pbi = JaminanKesehatan::where('golongan', 'pbi')->whereYear('created_at', Session::get('year'))->get();
        $nonPbi = JaminanKesehatan::where('golongan', 'non_pbi')->whereYear('created_at', Session::get('year'))->get();
        $jumlahNonPbi = JaminanKesehatan::where('golongan', 'non_pbi')->whereYear('created_at', Session::get('year'))->sum('jumlah');
        $jumlahPbi = JaminanKesehatan::where('golongan', 'pbi')->whereYear('created_at', Session::get('year'))->sum('jumlah');
        $jumlahPenduduk = JumlahPenduduk::whereYear('created_at', Session::get('year'))->get();
        $totalPenduduk = $jumlahPenduduk->sum('laki_laki') + $jumlahPenduduk->sum('perempuan');
        // dd(UnitKerja::first()->jumlah_k1);

        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'pbi' =>  $pbi,
            'nonPbi' => $nonPbi,
            'jumlahPbi' => $jumlahPbi,
            'jumlahNonPbi' => $jumlahNonPbi,
            'totalPenduduk' => $totalPenduduk
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
        $jumlahPenduduk = JumlahPenduduk::all();
        $totalPenduduk = $jumlahPenduduk->sum('laki_laki') + $jumlahPenduduk->sum('perempuan');
        $jaminanKesehatan = JaminanKesehatan::where('id', $request->id)->first();
        $jaminanKesehatan->update([
            $request->name => $request->value,
        ]);
        $persen = $totalPenduduk>0?number_format($jaminanKesehatan->jumlah/$totalPenduduk, 2):0;
        return response()->json([
            'status' => 'success',
            'persen' => $persen,
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

                $JaminanKesehatanOne = JaminanKesehatan::where('nama_kepesertaan', 'LIKE', '%'.$row[1].'%')->whereYear('created_at', Session::get('year'))->first();
                if($JaminanKesehatanOne) {
                    $JaminanKesehatanAdd = JaminanKesehatan::find($JaminanKesehatanOne->id);
                } else {
                    $JaminanKesehatanAdd = new JaminanKesehatan;
                }
                $JaminanKesehatanAdd->nama_kepesertaan = $row[1];
                $JaminanKesehatanAdd->golongan = $row[2];
                $JaminanKesehatanAdd->jumlah = $row[3];


                $JaminanKesehatanAdd->save();

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
    public function JaminanNew(Request $request)
    {
        try {
            JaminanKesehatan::create($request->all());
            return redirect()->route($this->routeName.'.index')->with(['success'=>'Berhasil menambahkan Data Peserta Jaminan Kesehatan']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->routeName.'.index')->with(['failure'=>$th->getMessage()]);
        }
        //
    }
}
