<?php

namespace App\Http\Controllers;

use App\Exports\FasilitasKesehatanExport;
use App\Models\FasilitasKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class FasilitasKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'FasilitasKesehatan';
    protected $viewName = 'fasilitas_kesehatan';
    protected $title = 'Fasilitas Kesehatan';
    public function index()
    {
        //
        $RumahSakit = FasilitasKesehatan::where('tipe', 'RUMAH SAKIT')->whereYear('created_at', Session::get('year'))->get();
        $Puskesmas = FasilitasKesehatan::where('tipe', 'PUSKESMAS DAN JARINGANNYA')->whereYear('created_at', Session::get('year'))->get();
        $Farmasi = FasilitasKesehatan::where('tipe', 'PUSKESMAS DAN SARANA PRODUKSI DAN DISTRIBUSI KEFARMASIAN')->whereYear('created_at', Session::get('year'))->get();
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'RumahSakit' => $RumahSakit,
            'Puskesmas' => $Puskesmas,
            'Farmasi' => $Farmasi,

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
        $FasilitasKesehatan = FasilitasKesehatan::where('id', $request->id)->first();
        $FasilitasKesehatan->update([
            $request->name => $request->value,
        ]);
        $total = $FasilitasKesehatan->kemenkes + $FasilitasKesehatan->pemprov + $FasilitasKesehatan->pemkot + $FasilitasKesehatan->tni_polri + $FasilitasKesehatan->bumn + $FasilitasKesehatan->ormas + $FasilitasKesehatan->swasta;
        return response()->json([
            'status' => 'success',
            'total' => $total,
        ]);
    }

    public function export() {
        try {
            return Excel::download(new FasilitasKesehatanExport, 'fasilitas_kesehatan_report_'.Session::get('year').'.xlsx');
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

                // $KelompokUmurExist = KelompokUmur::where('batas_bawah', $row[1])->where('batas_atas', $row[2])->whereYear('created_at', Session::get('year'))->first();
                // // dd($ObatEsensialExist);
                // if($KelompokUmurExist) {
                //     $KelompokUmurStore = KelompokUmur::find($KelompokUmurExist->id);
                // } else {

                //     $KelompokUmurStore->batas_bawah = $row[1];
                //     $KelompokUmurStore->batas_atas = $row[2];
                // }
                $FasilitasKesehatanStore = new FasilitasKesehatan();
                $FasilitasKesehatanStore->fasilitas_kesehatan = $row[1];
                $FasilitasKesehatanStore->tipe = $row[2];
                $FasilitasKesehatanStore->kemenkes = $row[3];
                $FasilitasKesehatanStore->pemprov = $row[4];
                $FasilitasKesehatanStore->pemkot = $row[5];
                $FasilitasKesehatanStore->tni_polri = $row[6];
                $FasilitasKesehatanStore->bumn = $row[7];
                $FasilitasKesehatanStore->swasta = $row[8];
                $FasilitasKesehatanStore->ormas = $row[9];
                $FasilitasKesehatanStore->gawat_darurat_1 = 0;

                $FasilitasKesehatanStore->save();

                setlocale(LC_TIME, 0);
            }
            if (!check_internet_connection()) {
                DB::rollBack(); // Rollback the transaction
                return redirect()->back()->with('error', 'Koneksi Hilang saat proses import data');
            }
        }
        DB::commit();

        return redirect($this->routeName)->with(['success'=>'Berhasil Menambah Sasaran']);
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
