<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\TagihanPemasangan;
use App\Models\PembayaranPemasangan;

use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CekTagihanController extends Controller
{
    protected $routeName = 'cek_tagihan';
    protected $viewName = 'cek_tagihan';
    protected $title = 'Cek Tagihan';

    public function tagihan()
    {
        $route = $this->routeName;
        return view($this->viewName.'.tagihan.index',compact('route'));
    }

    public function tagihan_pemasangan()
    {
        $route = $this->routeName;
        return view($this->viewName.'.tagihan_pemasangan.index',compact('route'));
    }

    public function datatable_tagihan(Request $request)
    {
        $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('tagihans.id','id_tagihan','tanggal','meter_penggunaan','pelanggans.name','tagihans.jumlah_pembayaran')->where('id_pelanggan', $request->id);

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F');
            })
            ->addColumn('tahun', function ($data) {
                return $data->tanggal->format('Y');
            })
            ->addColumn('status', function ($data){
                return $data->status;
            })
            ->addColumn('action', function ($data) {
                $route = 'tagihan';
                return view('layouts.includes.table-action-alt',compact('data','route'));
            });

        return $datatables->make(true);
    }

    public function datatable_tagihan_pemasangan(Request $request)
    {
        $datas = TagihanPemasangan::join('pelanggans','pelanggans.id','=','tagihan_pemasangans.pelanggan_id')->select('tagihan_pemasangans.id','id_tagihan_pemasangan','tanggal','pelanggans.name','tagihan_pemasangans.jumlah_pembayaran')->where('id_pelanggan', $request->id);

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('jumlah_pembayaran',function($data){

                $datas = TagihanPemasangan::find($data->id);

                $pembayaran_pemasangan = PembayaranPemasangan::where('tagihan_pemasangan_id', $datas->id);

                $total = $pembayaran_pemasangan->sum('jumlah_pembayaran');

                $pembayaran = $pembayaran_pemasangan->count();

                $jumlah_pembayaran = 3300000 - $total;


                $jumlah = $data->jumlah_pembayaran;
                return "Rp. ".number_format($jumlah_pembayaran);
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('d F Y');
            })
            // ->addColumn('tahun', function ($data) {
            //     return $data->tanggal->format('Y');
            // })
            ->addColumn('action', function ($data) {
                $route = 'tagihan_pemasangan';
                return view('layouts.includes.table-action-alt-2',compact('data','route'));
            });

        return $datatables->make(true);
    }
}
