<?php

namespace App\Http\Controllers\Api;

use DB;
use Carbon\Carbon;

use App\Models\Log;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CallBackVaRequest;
use App\Http\Requests\CallbackQrisRequest;

class TagihanController extends Controller
{
    public function tagihan(Request $request)
    {
        try {

            if(isset($request->id_tagihan)){
                $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('tagihans.id','id_tagihan','pelanggans.name')->where('tagihans.id_tagihan','like','%'.$request->id_tagihan.'%')->get();
            }else{
                $datas = Tagihan::join('pelanggans','pelanggans.id','=','tagihans.pelanggan_id')->select('tagihans.id','id_tagihan','pelanggans.name')->get();
            }

            $data = [
                'status' => 200,
                'data' => $datas,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Tagihan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
        
    }

    public function tagihan_detail(Request $request)
    {
        try {
            $datas = Tagihan::where('id_tagihan', '=', $request->id_tagihan)->first();
            
            $tagihans_sebelumnya = Tagihan::where('pelanggan_id', $datas->pelanggan_id)->whereNotIn('id', [$datas->id])->where('created_at','<',$datas->created_at)->orderBy('created_at','desc');

            $jumlah_tagihan = $tagihans_sebelumnya->count();
    
            if($jumlah_tagihan > 0){
                $meter_sebelumnya = $tagihans_sebelumnya->first()->meter_penggunaan;
            }else if($jumlah_tagihan <= 0){
                $meter_sebelumnya = 0;
            }
    
            if($datas->has('pembayaran')){
                $status = 'Telah Dibayar';
            }else if(!$datas->has('pembayaran')){
                $status = 'Menunggu Pembayaran';
            }else{
                $status = 'Menunggu Pembayaran';
            }
    
            $total_pemakaian = $datas->meter_penggunaan - $meter_sebelumnya;

            $tagihan = [
                'id_pelanggan' => $datas->pelanggan->id,
                'nama' => $datas->pelanggan->name,
                'no_telepon' => $datas->pelanggan->no_telepon,
                'alamat' => $datas->pelanggan->alamat,
                'no_tagihan' => $datas->id_tagihan,
                'periode' => $datas->tanggal->format('Y').' '.$datas->tanggal->format('F'). ' '. $datas->tanggal->format('d'),
                'meter_sekarang' => $datas->meter_penggunaan,
                'meter_sebelumnya' => $meter_sebelumnya,
                'pemakaian' => $total_pemakaian,
                'tagihan' => number_format($datas->jumlah_pembayaran),
                'denda Keterlambatan' => number_format($datas->denda_harian),
                'Sanksi Administrasi' => number_format($datas->denda_admin),
                'Total Tagihan' => number_format($datas->jumlah_pembayaran + $datas->denda_harian + $datas->denda_admin)
            ];

            $data = [
                'status' => 200,
                'data' => $tagihan,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Tagihan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
        
    }

    public function tagihan_terlambat()
    {
        try {
            $datas = Tagihan::doesntHave('pembayaran')->orderBy('created_at', 'DESC')->get();

            $tagihan = [];

            foreach($datas as $d){
                if($d->tanggal->format('Y-m-d') < date('Y-m-d')){
                    $tagihan[] = [
                        'id' => $d->id,
                        'no_tagihan' => $d->id_tagihan,
                        'nama' => $d->pelanggan->name
                    ];
                }
            }

            $data = [
                'status' => 200,
                'data' => $tagihan,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Tagihan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
        
    }

    public function tagihan_terlambat_detail(Request $request)
    {
        try {
            $datas = Tagihan::find($request->id);

            $diff = $datas->tanggal->diffInDays(date('Y-m-d'));

            $tagihan = [
                'id_pelanggan' => $datas->pelanggan->id_pelanggan,
                'nama' => $datas->pelanggan->name,
                'no_telepon' => $datas->pelanggan->no_telepon,
                'alamat' => $datas->pelanggan->alamat,
                'no_tagihan' => $datas->id_tagihan,
                'periode' => $datas->tanggal->format('Y').' '.$datas->tanggal->format('F'),
                'tagihan' => $datas->jumlah_pembayaran,
                'keterlambatan' => $diff.' Hari',
                'denda' => 0,
                'total' => $datas->jumlah_pembayaran + 0,
            ];

            $data = [
                'status' => 200,
                'data' => $tagihan,
            ];
        } catch (\Throwable $th) {
            $data = [
                'status' => 500,
                'message' => 'Tagihan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
        
    }

    public function callbackQris(CallbackQrisRequest $request){
        DB::beginTransaction();
        try {
            $tagihan = Tagihan::where(['kd_tagihan'=>$request->kd_tagihan,'metode'=>'QRIS','status'=>1])->orWhere(['kd_tagihan'=>$request->kd_tagihan, 'metode'=>'QRIS', 'status'=>5])
            ->limit(1);

            if ($tagihan->get()->count() > 0) {
                $tagihan->update([
                    'status'=>2,
                    'tanggal_penerimaan' => Carbon::now()->format('Y-m-d'),
                ]);
                Log::create([
                    'pengguna' => Auth::user()->name,
                    'kegiatan' => "Membayar dengan QRIS ".$tagihan->pelanggan->name. " dengan Jumlah Rp. ". $tagihan->jumlah_pembayaran,
                ]);
                DB::commit();
                return response()->json(['code'=>'00','message'=>'success']);
            }else{
                 return response()->json(['code'=>'99','message'=>'Data tidak ditemukan']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['code'=>500,'message'=>'terjadi kegagalan pada sistem']);
        }
    }

    public function callbackVa(CallBackVaRequest $request){
        DB::beginTransaction();
        try {
            $tagihan = Tagihan::where(['kd_tagihan'=>$request->number,'metode'=>'Virtual Account','status'=>1])->orWhere(['kd_tagihan'=>$request->kd_tagihan, 'metode'=>'Virtual Account', 'status'=>5])
                ->limit(1);
            if ($tagihan->get()->count() > 0) {
                 $tagihan->update([
                    'status'=>2,
                    'tanggal_penerimaan' => Carbon::now()->format('Y-m-d'),
                ]);
                Log::create([
                    'pengguna' => Auth::user()->name,
                    'kegiatan' => "Membayar dengan VA ".$tagihan->pelanggan->name. " dengan Jumlah Rp. ". $tagihan->jumlah_pembayaran,
                ]);
                DB::commit();
                return response()->json(['code'=>'00','message'=>'success']);
            }else{
                return response()->json(['code'=>'99','message'=>'Data tidak ditemukan']);
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['code'=>500,'message'=>'terjadi kegagalan pada sistem']);
        }
    }
}
