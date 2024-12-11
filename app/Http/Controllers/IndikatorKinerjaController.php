<?php

namespace App\Http\Controllers;

use App\Exports\IndikatorKinerjaExport;
use App\Models\AngkaKematian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class IndikatorKinerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'IndikatorKinerja';
    protected $viewName = 'indikator_kinerja';
    protected $title = 'Indikator Kinerja';
    public function index()
    {
        //
        $AngkaKematian = AngkaKematian::whereYear('created_at', Session::get('year'))->get();
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'AngkaKematian' => $AngkaKematian,
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
        $angkaKematian = AngkaKematian::where('id', $request->id)->first();
        $angkaKematian->update([
            $request->name => $request->value,
        ]);
        $bor = $angkaKematian->jumlah_tempat_tidur>0?number_format($angkaKematian->jumlah_hari_perawatan/($angkaKematian->jumlah_tempat_tidur * 365) * 100, 2):0;
        $bto = $angkaKematian->jumlah_tempat_tidur>0?number_format(($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P)/$angkaKematian->jumlah_tempat_tidur, 2):0;
        $toi = $angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format((($angkaKematian->jumlah_tempat_tidur * 365) - $angkaKematian->jumlah_hari_perawatan)/($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P), 2):0;
        $alos = $angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P>0?number_format($angkaKematian->jumlah_lama_dirawat/($angkaKematian->pasien_keluar_hidup_mati_L + $angkaKematian->pasien_keluar_hidup_mati_P), 2):0;
        return response()->json([
            'status' => 'success',
            'bor' => $bor,
            'bto' => $bto,
            'toi' => $toi,
            'alos' => $alos,
        ]);
    }

    public function export() {
        try {
            return Excel::download(new IndikatorKinerjaExport, 'indikator_kinerja_report_'.Session::get('year').'.xlsx');
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

                $AngkaKematianOne = AngkaKematian::where('nama_rumah_sakit', 'LIKE', '%'.$row[1].'%')->whereYear('created_at', Session::get('year'))->first();
                if($AngkaKematianOne) {
                    $AngkaKematianAdd = AngkaKematian::find($AngkaKematianOne->id);
                } else {
                    $AngkaKematianAdd = new AngkaKematian;
                    $AngkaKematianAdd->jumlah_tempat_tidur = $row[2];
                }
                $AngkaKematianAdd->nama_rumah_sakit = $row[1];


                $AngkaKematianAdd->jumlah_hari_perawatan = $row[4];
                $AngkaKematianAdd->jumlah_lama_dirawat = $row[5];

                $AngkaKematianAdd->save();

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
}
