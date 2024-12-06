<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\JenisDenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PembayaranPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $routeName = 'PembayaranPelanggan';
    protected $viewName = 'PembayaranPelanggan';
    protected $title = 'Laporan Pembayaran';

    public function index()
    {
        //
        $route = $this->routeName;
        $title = $this->title;
        $sektor = Auth::user()->pelanggan;
        return view($this->viewName.'.index',compact('route','title', 'sektor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function datatable(Request $request)
    {
        
        if(Auth::user()->name != 'Admin'){
            $datas = Tagihan::with('pelanggan')->where(['pelanggan_id'=>$request->sektor, 'status' => 2]);
        }else if(Auth::user()->name == 'Admin'){
            $datas = Tagihan::with('pelanggan');
        }
        
        $jenis_denda = JenisDenda::where(['type'=>'Denda Keterlambatan'])->first();
        try {
            //code...
            $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('meter_penggunaan', function($data){
                if($data->meter_penggunaan_awal != null){
                    $penggunaan = $data->meter_penggunaan - $data->meter_penggunaan_awal;
                }else if($data->meter_penggunaan_awal == null){
                    $penggunaan = $data->meter_penggunaan;
                }
                return number_format($penggunaan);
                
            })
            ->editColumn('name',function($data){
                return $data->pelanggan->name;
            })
            ->editColumn('jumlah_pembayaran',function($data){
                $jumlah = $data->jumlah_pembayaran;
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return "Rp. ".number_format($jumlah, 2);
                }
            })
            ->editColumn('tanggal',function($data){
                return $data->tanggal->format('F').'-'.$data->tanggal->format('Y');
            })
            ->editColumn('tanggal_akhir',function($data){
                return date("F", strtotime($data->tanggal_akhir)).'-'.date("Y", strtotime($data->tanggal_akhir));
            })
            ->editColumn('status_pemb', function ($data){
                if ($data->status == 0) {
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                }elseif($data->status == 1 || $data->status == 4 || $data->status == 5 || $data->status == 6){
                    return '<h6 class="text-warning">Penetapan</h6>';
                } elseif($data->status == 3){
                    return '<h6 class="text-warning">Menunggu Konfirmasi</h6>';
                }
                elseif($data->status == 2){
                    return '<h6 class="text-success">Lunas</h6>';
                }
            })->rawColumns(['status_pemb', 'jumlah_pembayaran', 'total_tagihan', 'denda_admin', 'denda_Keterlambatan'])
            ->addColumn('denda_Keterlambatan',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_harian, 2);
                }
            })
            ->addColumn('total_tagihan',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_harian + $data->denda_admin + $data->jumlah_pembayaran, 2);
                }
            })
            ->addColumn('denda_admin',function($data){
                if($data->status == 0){
                    return '<h6 class="text-danger">Menunggu Penetapan</h6>';
                } else {
                    return 'Rp.'.number_format($data->denda_admin, 2);
                }
            })
            ->addColumn('action', function ($data) {
                $route = 'tagihan';
                $url2 = $data->file_path.''.$data->file_name;
                $url = '-';
                if($data->status == 3 || $data->status == 2){
                    $url = $data->pembayaran->file_path.''.$data->pembayaran->file_name;   
                }
                    return view('layouts.includes.table-action-lunas',compact('data','route', 'url', 'url2'));   
            });

        return $datatables->make(true);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        
    }

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
}
