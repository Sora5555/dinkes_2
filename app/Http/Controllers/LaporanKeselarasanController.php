<?php

namespace App\Http\Controllers;

use App\Models\IndikatorOpd;
use App\Models\IndikatorPemerintah;
use App\Models\Jabatan;
use App\Models\IndukOpd;
use App\Models\SasaranRenstra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LaporanKeselarasanController extends Controller
{
    protected $routeName = 'laporan_keselarasan';
    protected $viewName = 'laporan_keselarasan';
    protected $title = 'Laporan Keselarasan';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $induk_opd_arr = IndukOpd::pluck('nama', 'id');
        return view('laporan_keselarasan.index',compact('route','title', 'induk_opd_arr'));

    }

    public function datatable(Request $request){
        $modelArr = SasaranRenstra::where('induk_opd_id', $request->induk_opd)->get();
        $datatables = DataTables::of($modelArr)
        ->editColumn('sasaran_id', function($model){
           return $model->id;
        })
        ->editColumn('nama_sasaran', function($model){
            return $model->nama;
        })
        ->editColumn('checklist_sasaran_hasil', function($model){
            $data = $model;
            return view('layouts.includes.checklist-hasil-sasaran',compact('data'));
        })
        ->editColumn('indikator_opd_nomor', function($model){
            $data = $model;
            return view('layouts.includes.indikator-opd-nomor',compact('data'));
        })
        ->editColumn('indikator_opd', function($model){
            $data = $model;
            return view('layouts.includes.indikator-opd',compact('data'));
        })
        ->editColumn('checklist_indikator_berkualitas', function($model){
            $data = $model;
            return view('layouts.includes.checklist-indikator-berkualitas',compact('data'));
        })
        ->editColumn('iku_bukan_iku_indikator_renstra', function($model){
            $data = $model;
            return view('layouts.includes.checklist-iku-renstra',compact('data'));
        })
        ->editColumn('nomor_detail_program', function($model){
            $data = $model;
            return view('layouts.includes.nomor-detail-program',compact('data'));
        })
        ->editColumn('detail_program', function($model){
            $data = $model;
            return view('layouts.includes.detail-program',compact('data'));
        })
        ->editColumn('detail_sasaran_program', function($model){
            $data = $model;
            return view('layouts.includes.detail-sasaran-program',compact('data'));
        })
        ->editColumn('detail_indikator_program', function($model){
            $data = $model;
            return view('layouts.includes.detail-indikator-program',compact('data'));
        })
        ->editColumn('checklist_program_terkait', function($model){
            $data = $model;
            return view('layouts.includes.checklist-program-terkait',compact('data'));
        })
        ->editColumn('detail_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-kegiatan',compact('data'));
        })
        ->editColumn('detail_sasaran_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-sasaran-kegiatan',compact('data'));
        })
        ->editColumn('detail_indikator_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-indikator-kegiatan',compact('data'));
        })
        ->editColumn('checklist_kegiatan_terkait', function($model){
            $data = $model;
            return view('layouts.includes.checklist-kegiatan-terkait',compact('data'));
        })
        ->editColumn('detail_sub_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-sub-kegiatan',compact('data'));
        })
        ->editColumn('detail_sasaran_sub_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-sasaran-sub-kegiatan',compact('data'));
        })
        ->editColumn('detail_indikator_sub_kegiatan', function($model){
            $data = $model;
            return view('layouts.includes.detail-indikator-sub-kegiatan',compact('data'));
        })
        ->editColumn('anggaran', function($model){
            $data = $model;
            return view('layouts.includes.anggaran',compact('data'));
        })
        ->rawColumns(['nama']);
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

    public function apiHasilSasaran($id){
        $sasaran = SasaranRenstra::where('id', $id)->first();
        if($sasaran->sasaran_hasil == 0){
            $sasaran->update([
                'sasaran_hasil' => 1
            ]);
        } else {
            $sasaran->update([
                'sasaran_hasil' => 0
            ]);
        }
        return response()->json([
            'success' => "berhasil Mengubah data",
        ]);
    }
    public function apiIndikatorOpdBerkualitas($id){
        $indikator = IndikatorOpd::where('id', $id)->first();
        if($indikator->berkualitas == 0){
            $indikator->update([
                'berkualitas' => 1
            ]);
        } else {
            $indikator->update([
                'berkualitas' => 0
            ]);
        }
        return response()->json([
            'success' => "berhasil Mengubah data",
        ]);
    }
    public function apiIndikatorPemerintahBerkualitas($id){
        $indikator = IndikatorPemerintah::where('id', $id)->first();
        if($indikator->berkualitas == 0){
            $indikator->update([
                'berkualitas' => 1
            ]);
        } else {
            $indikator->update([
                'berkualitas' => 0
            ]);
        }
        return response()->json([
            'success' => "berhasil Mengubah data",
        ]);
    }
    public function ikurenstra($id){
        $indikator = IndikatorPemerintah::where('id', $id)->first();
        if($indikator->iku == 0){
            $indikator->update([
                'iku' => 1
            ]);
        } else {
            $indikator->update([
                'iku' => 0
            ]);
        }
        return response()->json([
            'success' => "berhasil Mengubah data",
        ]);
    }
}
