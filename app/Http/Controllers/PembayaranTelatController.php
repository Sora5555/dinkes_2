<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PembayaranTelatController extends Controller
{
    protected $routeName = 'pembayaran_telat';
    protected $viewName = 'pembayaran_telat';
    protected $title = 'Pembayaran Telat';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $route = $this->routeName;
        $title = $this->title;
        return view($this->viewName.'.index',compact('route','title'));
    }

    public function datatable()
    {
        $datas = Pembayaran::join('tagihans','tagihans.id','=','pembayarans.tagihan_id')->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
        
        // ->whereDate('tagihans.tanggal','<','pembayarans.tanggal')
        ->whereRaw(' pembayarans.tanggal > tagihans.tanggal')
        ->select('pembayarans.id','pembayarans.id_pembayaran','pelanggans.id_pelanggan','pelanggans.name','tagihans.jumlah_pembayaran','tagihans.id_tagihan','pembayarans.created_at','tagihan_id');
        
        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->addColumn('hari',function($data){
                // return $data->tanggal->format('F');
                // $hari = Carbon::createFromFormat('Y-m-d',$data->created_at);
                // $hari2 = Carbon::createFromFormat('Y-m-d',$data->tagihan->tanggal);
                $tagihan = Tagihan::find($data->tagihan_id);
                $diff = $data->created_at->diffInDays($tagihan->tanggal);
                return $diff." Hari";
            })
            ->addColumn('action', function ($data) {
                $route = 'pembayaran';
                return view('layouts.includes.table-action',compact('data','route'));
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
}
