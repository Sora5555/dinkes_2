<?php

namespace App\Http\Controllers;

use App\Models\KelompokUmur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class KelompokUmurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'KelompokUmur';
    protected $viewName = 'kelompok_umur';
    protected $title = 'Kelompok Umur';
    public function index()
    {
        //
        $kelompokUmur = KelompokUmur::whereYear('created_at', Session::get('year'))->get();
        $total_laki_laki = 0;
        $total_perempuan = 0;
        foreach($kelompokUmur as $umur){
            $total_laki_laki += $umur->laki_laki;
            $total_perempuan += $umur->perempuan;
        }
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'kelompokUmur' => $kelompokUmur,
            'total_laki_laki' => $total_laki_laki,
            'total_perempuan' => $total_perempuan,
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
        $kelompokUmur = KelompokUmur::where('id', $request->id)->first();
        $kelompokUmur->update([
            $request->name => $request->value,
        ]);
        $total_laki_laki_perempuan = $kelompokUmur->laki_laki + $kelompokUmur->perempuan;
        $rasio = $kelompokUmur->perempuan > 0?number_format($kelompokUmur->laki_laki/$kelompokUmur->perempuan * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'total_laki_laki_perempuan' => $total_laki_laki_perempuan,
            'rasio' => $rasio,
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

                $KelompokUmurExist = KelompokUmur::where('batas_bawah', $row[1])->where('batas_atas', $row[2])->whereYear('created_at', Session::get('year'))->first();
                // dd($ObatEsensialExist);
                if($KelompokUmurExist) {
                    $KelompokUmurStore = KelompokUmur::find($KelompokUmurExist->id);
                } else {
                    $KelompokUmurStore = new KelompokUmur;
                    $KelompokUmurStore->batas_bawah = $row[1];
                    $KelompokUmurStore->batas_atas = $row[2];
                }

                $KelompokUmurStore->laki_laki = $row[3];
                $KelompokUmurStore->perempuan = $row[4];
                $KelompokUmurStore->save();

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
