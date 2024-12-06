<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Tagihan;
use App\Models\hariLibur;
use App\Models\Pembayaran;
use App\Traits\TraitsDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifiedController extends Controller
{
    use TraitsDenda;

    protected $routeName = 'verified';
    protected $viewName = 'verified';
    protected $title = 'verified';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        if(Auth::user()->roles->first()->name =='Admin'){
            $datas = Pembayaran::doesntHave("pelunasan")->join("tagihans", "pembayarans.tagihan_id", "=", "tagihans.id")->join("pelanggans", "pelanggans.id", "=", "tagihans.pelanggan_id")->where("tagihans.status", "=", 1)->orWhere('tagihans.status', '=', 3)->orWhere('tagihans.status', '=', 4)->orWhere('tagihans.status', '=', 5)->orWhere('tagihans.status', '=', 6)->select('pembayarans.id', 'pembayarans.file_name', 'pembayarans.file_path', 'tagihans.denda_harian', 'tagihans.denda_admin', 'tagihans.jumlah_pembayaran', 'pelanggans.daerah_id', 'pelanggans.name', 'tagihans.tanggal', 'pembayarans.created_at', 'tagihans.status', 'tagihans.id as tagihanid')->get();
        } else {
            $datas = Pembayaran::doesntHave("pelunasan")->join("tagihans", "pembayarans.tagihan_id", "=", "tagihans.id")->join("pelanggans", "pelanggans.id", "=", "tagihans.pelanggan_id")->where([["pelanggans.daerah_id", "=", Auth::user()->daerah_id], ["tagihans.status", "=", 1]])->orWhere([["pelanggans.daerah_id", "=", Auth::user()->daerah_id], ["tagihans.status", "=", 3]])->orWhere('tagihans.status', '=', 4)->orWhere('tagihans.status', '=', 5)->orWhere('tagihans.status', '=', 6)->select('pembayarans.id', 'pembayarans.file_name', 'pembayarans.file_path', 'tagihans.denda_harian', 'tagihans.denda_admin', 'tagihans.jumlah_pembayaran', 'pelanggans.daerah_id', 'pelanggans.name', 'tagihans.tanggal', 'pembayarans.created_at', 'tagihans.status', 'tagihans.id as tagihanid')->get();
        }
        $tagihans = Tagihan::where("status", 1)->get();
        $hariLibur = hariLibur::select('tanggal')->get();
        foreach($tagihans as $tagihan){
            $hlArr = [];
            foreach($hariLibur as $hl){
                array_push($hlArr, $hl->tanggal);
            }
            if($tagihan->pembayaran){
                $this->cekDendaPenetapan(2, $tagihan->pembayaran->tanggal, $tagihan, $hlArr);
            }
        }
        if(request()->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function ($data) {
                $route = 'target';
                return view('layouts.includes.table-action',compact('data','route'));
            })->editColumn('jumlah_pembayaran', function($data){
                return "Rp. ".number_format($data->jumlah_pembayaran + $data->denda_admin + $data->denda_harian, 2);
            })->editColumn('denda keterlambatan', function($data){
                return "Rp. ".number_format($data->denda_harian);
            })->editColumn('Sanksi administrasi', function($data){
                return "Rp. ".number_format($data->denda_admin);
            })->editColumn('tanggal', function($data){
                return $data->tanggal->format('Y-m-d');
            })->editColumn('created_at', function($data){
                return $data->created_at->format('Y-m-d');
            })
            ->addColumn('action', function ($data) {
                $route = 'verified';
                $url = $data->file_path.''.$data->file_name;
                return view('layouts.includes.table-action-nota',compact('data','route', 'url'));
            })->editColumn('status', function($data){
                if($data->status == 3){
                    return '<h5 class="text-warning">Menunggu Konfirmasi</h5>';
                } else {
                    return '<h5 class="text-success">Ditetapkan</h5>';
                }
            })->rawColumns(['status'])
            ->make(true);
        }
        return view($this->viewName.".index", compact("route", "title", "datas"));
    }

    public function datatable()
    {
        $datas = Pembayaran::doesntHave('pelunasan')->whereHas('tagihan.pelanggan.daerah',function($query){
            $query->where(['nama_daerah'=>Auth::user()->daerah->nama_daerah]);
        })
        ->with(['tagihan'=>function($query){
            $query->with(['pelanggan'=>function($query){
                $query->with('user');
            }]);
        }]);

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->tagihan->jumlah_pembayaran+$data->tagihan->denda_admin+$data->tagihan->denda_harian;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('id_pelanggan',function($data){
                return $data->tagihan->pelanggan->no_pelanggan;
            })
            ->editColumn('name',function($data){
                return $data->tagihan->pelanggan->name;
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->isoFormat('MMMM-Y');
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d');
            })
            ->addColumn('action', function ($data) {
                $route = 'verified';
                return view('layouts.includes.table-action-nota',compact('data','route'));
            });

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
    public function destroy(Request $request, $id)
    {
        //
        try{
            $query = Pembayaran::where('id', $id)->first();
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Menghapus data penetapan ".$query->tagihan->pelanggan->name." dengan jumlah Rp. ".$query->tagihan->jumlah_pembayaran,
            ]);
            $query->tagihan->delete();
            $query->delete();

            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Menghapus Data Pembayaran : '.$query->id_pembayaran]);
        }catch (\Exception $e){
            return redirect()->back()->with(['error'=>'Gagal Menghapus Data Pembayaran : '.$e->getMessage()])->withErrors($request->all());
        }
    }
}
