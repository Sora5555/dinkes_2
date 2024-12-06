<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\TagihanPemasangan;

class HomeController extends Controller
{
    public function index()
    {
        

        try {
            
            $pelanggan = Pelanggan::count();
            $tagihan = Tagihan::count();
            $pembayaran = Pembayaran::count();

            
            $jumlah_pembayaran = Tagihan::sum('jumlah_pembayaran');
            $jumlah_hutang = Tagihan::doesntHave('pembayaran')->sum('jumlah_pembayaran');

            $jumlah_pembayaran_pemasangan = TagihanPemasangan::sum('jumlah_pembayaran');
            $jumlah_hutang_pemasangan = 0;

            $tagihan_pemasangan = TagihanPemasangan::all();

            foreach ($tagihan_pemasangan as $tp) {
                $jumlah = $tp->pembayaran->sum('jumlah_pembayaran');
    
                if($jumlah < $tp->jumlah_pembayaran){
                    $jumlah_hutang_pemasangan += $tp->jumlah_pembayaran - $jumlah;
                }else if($jumlah >= $tp->jumlah_pembayaran){
                    // return "Sudah Lunas";
                }else{
                    $jumlah_hutang_pemasangan += $tp->jumlah_pembayaran - $jumlah;
                }
            }

            // $pembayaran_telat = Pembayaran::join('tagihans','tagihans.id','=','pembayarans.tagihan_id')->join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')
            // ->whereRaw(' pembayarans.tanggal > tagihans.tanggal')
            // ->select('pembayarans.id','pembayarans.id_pembayaran','pelanggans.id_pelanggan','pelanggans.name','tagihans.jumlah_pembayaran','tagihans.id_tagihan','pembayarans.created_at','tagihan_id')->count();

            $tagihans = Tagihan::doesntHave('pembayaran')->orderBy('created_at', 'DESC')->get();

            $pembayaran_telat = 0;
    
            foreach($tagihans as $t){
                if($t->tanggal->format('Y-m-d') < date('Y-m-d')){
                    $pembayaran_telat += 1;
                }
            }

            $datas = [
                'pelanggan' => $pelanggan,
                'tagihan' => $tagihan,
                'pembayaran' => $pembayaran,
                'pembayaran_telat' => $pembayaran_telat,
                'total_pembayaran' => $jumlah_pembayaran,
                'total_hutang' => $jumlah_hutang,
                'total_pembayaran_pemasangan' => $jumlah_pembayaran_pemasangan,
                'total_hutang_pemasangan' => $jumlah_pembayaran_pemasangan
            ];
            $data = [
                'status' => 200,
                'data' => $datas,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'data' => null,
                'error' => $th->getMessage(),
            ]; 
        }
        return response()->json($data,$data['status']);	
    }
}
