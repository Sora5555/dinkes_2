<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tagihan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function data_pelanggan(Request $request)
    {
        try{

            if(isset($request->id_pelanggan)){
                $datas = Pelanggan::where('id_pelanggan','like','%'.$request->id_pelanggan.'%')->get();
            }else{
                $datas = Pelanggan::all();
            }
            

            $data = [
                'status' => 200,
                'data' => $datas,
            ];
        } catch (\Throwable $th){
            $data = [
                'status' => 500,
                'message' => 'Pelanggan Tidak Ditemukan',
                'data' => null,
            ];
        }
        return response()->json($data,$data['status']);
    }

    public function detail_pelanggan(Request $request)
    {
        try {
            $datas = Pelanggan::find($request->id);
            $tagihans = Tagihan::where('pelanggan_id', $datas->id)->orderBy('created_at','desc');
            $jumlah_tagihan = $tagihans->count();
    
            // dd($jumlah_tagihan);
    
            if($jumlah_tagihan > 0){
                $meter_sebelumnya = $tagihans->first()->meter_penggunaan;
            }else if($jumlah_tagihan <= 0){
                $meter_sebelumnya = 0;
            }
    
            $histori = Tagihan::where('pelanggan_id', $datas->id)->orderBy('created_at','desc')->limit(3)->get();
            $penggunaan_bulan_ini = Tagihan::where('pelanggan_id', $datas->id)->whereMonth('tanggal', date('m'))->first();
    
            $data_pelanggan = [
                'id_pelanggan' => $datas->id_pelanggan,
                'name' => $datas->name,
                'no_telepon' => $datas->no_telepon,
                'alamat' => $datas->alamat,
                'meter_sebelumnya' => $meter_sebelumnya,
                'penggunaan_bulan_ini' => $penggunaan_bulan_ini,
                'histori_penggunaan' => $histori
            ];
    
            $data = [
                'status' => 200,
                'data' => $data_pelanggan,
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

    public function store(Request $request)
    {
        $validator = $request->validate([
            'id' => 'required|string|max:100',
            'meter_sekarang' => 'numeric|required|digits_between:1,100',
        ]);


        if($request->has('file')){
            $validator = $request->validate([
                'file' => 'max:5000',
            ]);   
        }

        if ($request->has('file')) {
            // dd($request->file('file'));
            $file=$request->file('file');
            $direktori=public_path().'/storage/image/';          
            $nama_file=str_replace(' ','-',$request->file->getClientOriginalName());
            $file_format= $request->file->getClientOriginalExtension();
            $uploadSuccess = $request->file->move($direktori,$nama_file);
        }

        $datas = Pelanggan::find($request->id);
        $tagihans = Tagihan::where('pelanggan_id', $datas->id)->orderBy('created_at','desc');

        $jumlah_tagihan = $tagihans->count();

        if($jumlah_tagihan > 0){
            $meter_sebelumnya = $tagihans->first()->meter_penggunaan;
        }else if($jumlah_tagihan <= 0){
            $meter_sebelumnya = 0;
        }

        $pemakaian = $request->meter_sekarang - $meter_sebelumnya;

        $jumlah_pembayaran = $pemakaian * 11500;


        try{
            DB::beginTransaction();
            $number = rand(0,1000);
            $txt = date("Ymdhis").''.$number;
            
            $id = $txt.$number;

            if($jumlah_tagihan > 0){
                $tanggal = $tagihans->first()->tanggal->addMonth(1);
            }else if($jumlah_tagihan <= 0){
                $tanggal = date('Y-m').'-20';
            }
            

            if (isset($uploadSuccess)) {
                $query = Tagihan::create([
                    'id_tagihan' => $txt,
                    'pelanggan_id' => $datas->id,
                    'tanggal'=> $tanggal,
                    'meter_penggunaan'=>$request->meter_sekarang,
                    'jumlah_pembayaran'=> $jumlah_pembayaran,
                    'file_name' => $nama_file,
                    'file_path' => '/storage/image/',
                ]);
            }else{
                $query = Tagihan::create([
                    'id_tagihan' => $txt,
                    'pelanggan_id' => $datas->id,
                    'tanggal'=>$tanggal,
                    'meter_penggunaan'=>$request->meter_sekarang,
                    'jumlah_pembayaran'=> $jumlah_pembayaran
                ]);
            }


            // $query = Tagihan::create([
            //     'id_tagihan' => $txt,
            //     'pelanggan_id' => $datas->id,
            //     'tanggal'=> $tagihans->first()->tanggal->addMonth(1),
            //     'meter_penggunaan'=>$request->meter_sekarang,
            //     'jumlah_pembayaran'=> $jumlah_pembayaran
            // ]);

            $data = [
                'status' => 200,
                'data' => $query,
            ];
            DB::commit(); 
        } catch (\Throwable $th){
            DB::rollBack();
            $data = [
                'status' => 500,
                'data' => null,
                'error' => $th->getMessage(),
            ]; 
        }

        return response()->json($data,$data['status']);	
    }
}
