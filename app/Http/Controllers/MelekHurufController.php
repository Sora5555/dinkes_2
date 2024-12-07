<?php

namespace App\Http\Controllers;

use App\Models\KelompokUmur;
use App\Models\MelekHuruf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class MelekHurufController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'MelekHuruf';
    protected $viewName = 'melek_huruf';
    protected $title = 'Melek Huruf';
    public function index()
    {
        //
        $MelekHuruf = MelekHuruf::whereYear('created_at', Session::get('year'))->get();
        $KelompokUmur = KelompokUmur::where('batas_bawah', '>=', 15)->get();
        $laki_laki = $KelompokUmur->sum('laki_laki');
        $perempuan = $KelompokUmur->sum('perempuan');
        $data=[
            'route'=>$this->routeName,
            'title'=>$this->title,
            'MelekHuruf' => $MelekHuruf,
            'KelompokUmur' => $KelompokUmur,
            'laki_laki' => $laki_laki,
            'perempuan' => $perempuan,
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
        $MelekHuruf = MelekHuruf::where('id', $request->id)->first();
        $KelompokUmur = KelompokUmur::where('batas_bawah', '>=', 15)->get();
        $laki_laki = $KelompokUmur->sum('laki_laki');
        $perempuan = $KelompokUmur->sum('perempuan');
        $MelekHuruf->update([
            $request->name => $request->value,
        ]);
        $total_laki_laki_perempuan = $MelekHuruf->laki_laki + $MelekHuruf->perempuan;
        $persen_laki_laki = $laki_laki>0?number_format($MelekHuruf->laki_laki/$laki_laki * 100, 2):0;
        $persen_perempuan = $perempuan>0?number_format($MelekHuruf->perempuan/$perempuan * 100, 2):0;
        $persen_laki_laki_perempuan = $perempuan + $laki_laki>0?number_format(($MelekHuruf->perempuan + $MelekHuruf->laki_laki)/($perempuan + $laki_laki) * 100, 2):0;
        return response()->json([
            'status' => 'success',
            'total_laki_laki_perempuan' => $total_laki_laki_perempuan,
            'persen_laki_laki' => $persen_laki_laki,
            'persen_perempuan' => $persen_perempuan,
            'persen_laki_laki_perempuan' => $persen_laki_laki_perempuan,
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

                // $KelompokUmurExist = KelompokUmur::where('batas_bawah', $row[1])->where('batas_atas', $row[2])->whereYear('created_at', Session::get('year'))->first();
                // // dd($ObatEsensialExist);
                // if($KelompokUmurExist) {
                //     $KelompokUmurStore = KelompokUmur::find($KelompokUmurExist->id);
                // } else {

                //     $KelompokUmurStore->batas_bawah = $row[1];
                //     $KelompokUmurStore->batas_atas = $row[2];
                // }
                $MelekHurufStore = new MelekHuruf();
                $MelekHurufStore->variabel = $row[1];
                $MelekHurufStore->laki_laki = $row[2];
                $MelekHurufStore->perempuan = $row[3];
                $MelekHurufStore->save();

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
