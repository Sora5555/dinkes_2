<?php

namespace App\Http\Controllers;

use App\Models\JaminanKesehatan;
use App\Models\JumlahPenduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
