<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\IndukOpd;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanPerjanjianKinerjaController extends Controller
{
    protected $routeName = 'laporan_penetapan_kinerja';
    protected $viewName = 'laporan_penetapan_kinerja';
    protected $title = 'Laporan Penetapan Kinerja';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        return view('laporan_perjanjian_kinerja1.index',compact('route','title', 'induk_opd_arr'));

    }

    public function dataTable(Request $request)
    {
        $model = Jabatan::where('induk_opd_id', $request->induk_opd)->get();

        $modelArr = [];

        $nameArrCheck = [];

        $idArrCheck = [];

        foreach ($model as $key => $value) {
            if($value->descendants()->count() > 0){
                $variable = $value->descendantsAndSelf()->get();
                foreach ($variable as $key => $value1) {
                    # code...
                    if(!in_array($value1->nama, $nameArrCheck)){
                            array_push($nameArrCheck, $value1->nama);
                            array_push($modelArr, $value1);
                        }
                }
            } else {
                if($value->descendants()->count() == 0 && !in_array($value->nama, $nameArrCheck)){
                    array_push($modelArr, $value);
                    array_push($nameArrCheck, $value->nama);
                }
            }
        }
        $modelArr = collect((object) $modelArr);
        $modelArr = $modelArr->sortBy('path');
        $datatables = DataTables::of($modelArr)
        ->addColumn('jabatan', function($modelArr){
            $char = $modelArr->level * $modelArr->level * 4;
            $charRes = $char . 'px';
           return "<span style='padding-left:$charRes'>$modelArr->nama</span>";
        })
        ->addColumn('nip', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->nip;
            } else {
                return "-";
            }
        })
        ->addColumn('nama', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->nama;
            } else {
                return "-";
            }
        })
        ->addColumn('golongan', function($modelArr){
            if($modelArr->Pemangku){
                return $modelArr->Pemangku->Golongan->nama;
            } else {
                return "-";
            }
        })
        ->addColumn('action', function($modelArr){
            $route = 'laporan';
            $data = $modelArr;
            return view('layouts.includes.table-action-pemangku',compact('data','route'));
        })
        ->rawColumns(['jabatan']);
        return $datatables->make(true);
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

    public function pdf_laporan($id){
        $data = Jabatan::where('id', $id)->first();
        return view('tagihan.pemberitahuan')->with($data);
    }
}
