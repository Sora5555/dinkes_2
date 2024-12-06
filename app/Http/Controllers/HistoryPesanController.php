<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Helper\Helper;
use App\Models\Log;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\HistoryPesan;
use Illuminate\Http\Request;
use App\Models\TemplatePesan;
use App\Models\UptDaerah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HistoryPesanController extends Controller
{
    protected $routeName = 'history_pesan';
    protected $viewName = 'history_pesan';
    protected $title = 'History Pesan';
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
        $datas = HistoryPesan::join('pelanggans','pelanggans.id','=','history_pesans.pelanggan_id')->join('template_pesans','template_pesans.id','=','history_pesans.template_pesan_id')->select('history_pesans.id','pelanggan_id','template_pesan_id','history_pesans.created_at','pelanggans.no_telepon','template_pesans.nama_pesan');

        $datatables = DataTables::of($datas)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return $data->created_at->format('Y-m-d H:i:s');
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
        $route = $this->routeName;
        $title = $this->title;
        $pelanggans = Pelanggan::all();
        $upt_daerahs = UptDaerah::all();
        $pesans = TemplatePesan::all();

        return view($this->viewName.'.create',compact('route','title','pelanggans','pesans', 'upt_daerahs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = $request->validate([
            'pelanggan' => 'required',
            'template_pesan' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $nomors = $request->pelanggan;
            foreach($nomors as $nomor){
                $query = HistoryPesan::create([
                    'pelanggan_id' => $nomor,
                    'template_pesan_id' => $request->template_pesan
                ]);
    
                $pelanggan = Pelanggan::find($nomor);
                $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->orderBy('created_at','desc')->first();
                if($tagihan){
                    $tanggal = Carbon::parse($tagihan->tanggal)->isoFormat('MMMM');
                    $meter_penggunaan = $tagihan->meter_penggunaan;
                    $jumlah_pembayaran = number_format($tagihan->jumlah_pembayaran);
    
                }
    
                $id_pelanggan = $pelanggan->id;
                $nama_pelanggan = $pelanggan->name;
                $alamat = $pelanggan->alamat;
                $template_pesan = TemplatePesan::find($request->template_pesan);
    
                $msg = $template_pesan->isi_pesan;
    
                // preg_match_all('~\{\$(.*?)\}~si', $msg, $matches);
                // if ( isset($matches[1])) {
                //     $r = compact($matches[1]);
                //     foreach ( $r as $var => $value ) {
                //         $msg = str_replace('{' . $var . '}', $value, $msg);
                //     }
                // }
    
                $vars  = array(
                    '{id_pelanggan}' => $id_pelanggan,
                    '{nama_pelanggan}' => $nama_pelanggan,
                    '{alamat}' => $alamat,
                    '{tanggal}' => isset($tanggal)?strtoupper($tanggal):"-",
                    '{meter_penggunaan}' => isset($meter_penggunaan)?$meter_penggunaan:0,
                    '{jumlah_pembayaran}' => isset($jumlah_pembayaran)?$jumlah_pembayaran:0,
                );
    
                $msg1 = strtr($msg, $vars);
                // dd($msg1);
    
                Helper::sendWa($pelanggan->no_telepon,$msg1);
                DB::commit(); 
            }
            Log::create([
                'pengguna' => Auth::user()->name,
                'kegiatan' => "Mengirim Pesan WhatssApp"
            ]);
            return redirect(route($this->routeName.'.index'))->with(['success'=>'Berhasil Mengirim Pesan : '.$query->id_pembayaran]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error'=>'Gagal Mengirim Pesan : '.$e->getMessage()])->withErrors($request->all());
        }

        
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

    public function kirim_pesan($id)
    {
        $pelanggan = Pelanggan::find($id);
        $tagihan = Tagihan::where('pelanggan_id', $pelanggan->id)->orderBy('created_at','desc')->first();

        $tanggal = Carbon::parse($tagihan->tanggal)->isoFormat('MMMM');
        
        $id_pelanggan = $pelanggan->id_pelanggan;
        $name = $pelanggan->name;
        $alamat = $pelanggan->alamat;
        $meter_penggunaan = $tagihan->meter_penggunaan;
        $jumlah_pembayaran = number_format($tagihan->jumlah_pembayaran);


$msg = "Tagihan PDAM
No. Pelanggan : ".$pelanggan->id_pelanggan."
Nama : ". $pelanggan->name ."
Alamat : ". $pelanggan->alamat ."

TAGIHAN PDAM BULAN ". strtoupper($tanggal) ."
--------------------------------------------
Penggunaan : ". $tagihan->meter_penggunaan ." m³
Tagihan : Rp. ". number_format($tagihan->jumlah_pembayaran) ."
";      

        Helper::sendWa($pelanggan->no_telepon,$msg);
    }
    
    public function kirim_pesan_terlambat()
    {
        $datas = Tagihan::doesntHave('pembayaran')->orderBy('created_at', 'DESC')->get();

        $tagihan = [];

        $jumlah_terlambat = 0;

        foreach($datas as $d){
            if($d->tanggal->format('Y-m-d') < date('Y-m-d')){
                $jumlah_terlambat += 1;
                $query = HistoryPesan::create([
                    'pelanggan_id' => $d->pelanggan->id,
                    'template_pesan_id' => Profile()->template_pesan_terlambat_id
                ]);

                // $diff = $d->tanggal->diffInDays(Carbon::now()->format('Y-m-d'));

                $tanggal = Carbon::parse($d->tanggal)->isoFormat('MMMM');

                $id_pelanggan = $d->pelanggan->id_pelanggan;
                $nama_pelanggan = $d->pelanggan->name;
                $alamat = $d->pelanggan->alamat;
                $meter_penggunaan = $d->meter_penggunaan;
                $jumlah_pembayaran = number_format($d->jumlah_pembayaran);

                $template_pesan = TemplatePesan::find(Profile()->template_pesan_terlambat_id);

                $msg = $template_pesan->isi_pesan;
                
                $vars  = array(
                    '{id_pelanggan}' => $id_pelanggan,
                    '{nama_pelanggan}' => $nama_pelanggan,
                    '{alamat}' => $alamat,
                    '{tanggal}' => strtoupper($tanggal),
                    '{meter_penggunaan}' => $meter_penggunaan,
                    '{jumlah_pembayaran}' => $jumlah_pembayaran
                );
    
                $msg1 = strtr($msg, $vars);
    
                // dd($msg1);
                // dd($d->pelanggan->no_telepon);
                Helper::sendWa($d->pelanggan->no_telepon,$msg1);

                // sendWa($pelanggan->no_telepon,$msg);
            }
        }

        if($jumlah_terlambat > 0){
            $template_pesan2 = TemplatePesan::find(Profile()->template_pesan_terlambat_manager_id);
            $manager = User::where('role_id', 4)->get();
            $msg2 = $template_pesan2->isi_pesan;     
            foreach ($manager as $m) {
                
                Helper::sendWa($m->no_telepon,$msg2);
            }
            
        }
    }
}
