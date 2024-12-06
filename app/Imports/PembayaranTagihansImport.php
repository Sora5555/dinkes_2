<?php

namespace App\Imports;

use App\Models\Pelanggan;
use App\Models\Pelunasan;
use App\Models\Pembayaran;
use App\Models\Role;
use App\Models\Tagihan;
use App\Models\Target;
use App\Models\UptDaerah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PembayaranTagihansImport implements ToArray,WithHeadingRow,WithCalculatedFormulas
{   
    public $results = [];
    /**
    * @param Collection $collection
    */
    public function array(array $array)
    {   
        
        //fix merge cell
        $datas = [];
        foreach ($array as $key => $value) {
            if(isset($value['id_kota']) && $value['id_kota'] != null && $value['tanggal'] != null){
                $value['tanggal'] = str_replace("  "," ",$value['tanggal']);
                $value['pemakaian_awal'] = str_replace("  "," ",$value['pemakaian_awal']);
                $datas[] = $value;
            } else if (isset($value['volume']) && $value['volume'] != null && count($datas) > 0){
                $datas[(count($datas)-1)]['volume'] += $value['volume'];
            }
        }

        $double_data = request()->double_data;
     
        DB::beginTransaction();
        try {
            foreach ($datas as $key => $data) {
                $upt = UptDaerah::find((int)$data['id_kota']);
                if($upt){
                    try {
                        $wajib_pajak = ($data['wajib_pajak'] == "PDAM")?$data['wajib_pajak']." ".$upt->nama_daerah:$data['wajib_pajak'];
                        $email = strtolower(str_replace(" ","",$wajib_pajak)).'@mail.com';
                        $role = Role::findOrFail("2");
                        //cek user berdasarkan nama, daerah dan emailnya
                        $user = User::where(function($w)use($wajib_pajak,$email){
                            $w->where('name',$wajib_pajak)->orWhere('email',$email);
                        })->where('daerah_id',$upt->id)->first();
                        if(!$user){
                            //email double maka emailnya di tambahin nama kota/kabupaten
                            $cek_email = $user = User::where('email',$email)->first();
                            if($cek_email){
                                $email = strtolower(str_replace(" ","",$wajib_pajak)).'.'.strtolower(str_replace(" ","",$upt->nama_daerah)).'@mail.com';
                            }
                            $user = User::create([
                                'name'=>$wajib_pajak,
                                'email'=>$email,
                                'daerah_id'=>$upt->id,
                                'password'=>Hash::make('perusahaan123'),
                            ]);
                        }
                        $user->assignRole($role->name);
                        $pelanggan = Pelanggan::firstOrCreate([
                            'name'=>$wajib_pajak,
                            'daerah_id'=>$upt->id,
                        ],[
                            'user_id'=>$user->id,
                        ]);
                        $pelanggan->update([
                            'no_pelanggan'=>sprintf("%02d", $pelanggan->daerah_id).sprintf("%06d", $pelanggan->id),
                        ]);
                        
                        
        
                        $number = rand(0,1000);
                        $txt = date("Ymdhis").''.$number;
                        $id_tagihan = $txt.$number;
                        
                        $bulanIndo = config('app.months');
                        try {
                            $tanggal_penerimaan =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(str_replace("'","",$data['tanggal']));
                          
                        } catch (\Throwable $th) {
                            
                            try {
                                $tanggal_penerimaan = Carbon::parse(str_replace("'","",str_replace(" ","",$data['tanggal'])));
                                
                            } catch (\Throwable $th) {
                               
                                $tanggal_penerimaan = null;
                            }
                        }
                        $pemakaian_awal = null;
                        $pemakaian_akhir = null;
                        try {
                            $pemakaian_awal =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(str_replace("'","",$data['pemakaian_awal']));
                            $pemakaian_akhir =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(str_replace("'","",$data['pemakaian_akhir']));
                          
                        } catch (\Throwable $th) {
                            
                            try {
                                $pemakaian_awal = Carbon::parse(str_replace("'","",str_replace(" ","",$data['pemakaian_awal'])));
                                $pemakaian_akhir = Carbon::parse(str_replace("'","",str_replace(" ","",$data['pemakaian_akhir'])));
                                
                            } catch (\Throwable $th) {
                               
                                $pemakaian_awal = null;
                                $pemakaian_akhir = null;
                            }
                        }
                        

                        $tanggal_penerimaan_arr = explode(" ",str_replace("'","",trim($data['tanggal'])));
                        $pemakaian_awal_arr = explode(" ",str_replace("'","",trim($data['pemakaian_awal'])));
                        $pemakaian_akhir_arr = explode(" ",str_replace("'","",trim($data['pemakaian_akhir'])));
                      
        
                        if(((isset($tanggal_penerimaan_arr[1]) && in_array(strtoupper($tanggal_penerimaan_arr[1]),$bulanIndo)) || $tanggal_penerimaan != null) && ((in_array(strtoupper($pemakaian_awal_arr[0]),$bulanIndo) && count($pemakaian_awal_arr) == 2) || $pemakaian_awal != null) && ((in_array(strtoupper($pemakaian_akhir_arr[0]),$bulanIndo) && count($pemakaian_akhir_arr) == 2) || $pemakaian_akhir != null)){
                            $bulanIndexPemakaiaan = array_search(strtoupper($pemakaian_awal_arr[0]),$bulanIndo);
                            if($pemakaian_awal == null){
                                $pemakaian_awal = Carbon::parse("1-".$bulanIndexPemakaiaan."-".$pemakaian_awal_arr[1]);
                            }

                            $bulanIndexPemakaiaanAkhir = array_search(strtoupper($pemakaian_akhir_arr[0]),$bulanIndo);
                            if($pemakaian_akhir == null){
                                $pemakaian_akhir = Carbon::parse("1-".$bulanIndexPemakaiaanAkhir."-".$pemakaian_akhir_arr[1]);
                            }
                            $new_tagihan = true;
                            
                            //jika bukan pilihan tetap tambah tagihan
                            if($double_data != 3){
                                $cek_tagihan = Tagihan::where('pelanggan_id',$pelanggan->id)->where('tanggal',$pemakaian_awal->format("Y-m-d"))->first();
                                if($cek_tagihan){
                                    $new_tagihan = false;

                                    //jika memilih mengupdate data yang ada
                                    if($double_data == 2){
                                        $jumlah_pembayaran_lama = $cek_tagihan->jumlah_pembayaran;
                                        $cek_tagihan->update([
                                            'meter_penggunaan' => (int)$data['volume'],
                                            'jumlah_pembayaran' => (int)$data['pokok'],
                                            'denda_harian' => (int)$data['denda'],
                                        ]);

                                        $number2 = rand(0, 1000);
                                        $id_pembayaran = date("Ymdhis").''.$number2;
                                        
                                        if($tanggal_penerimaan == null){
                                            $bulanIndexPenerimaan = array_search(strtoupper($tanggal_penerimaan_arr[1]),$bulanIndo);
                                            $tanggal_penerimaan = Carbon::parse($tanggal_penerimaan_arr[0]."-".$bulanIndexPenerimaan."-".$tanggal_penerimaan_arr[2]);
                                        }
                                        
                                        //update target
                                        $target = Target::where("id_daerah", "=", $upt->id)->first();
                                        if($target){
                                            //kurangi dengan jumlah pembayaran lama kemudian di tambah jumlah pembayaran baru
                                            $target->update(["realisasi" => ($target->realisasi - $jumlah_pembayaran_lama) + (int)$data['pokok']]);
                                        } else {
                                            $this->results[] = [
                                                'message'=>"Target untuk daerah ".$upt->nama_daerah." tidak ditemukan",
                                                'status'=>'warning'
                                            ];
                                        }

                                        $this->results[] = [
                                            'message'=>"Data untuk pelanggan ".$pelanggan->name." pada pemakaian ".$data['pemakaian_awal']." berhasil di update",
                                            'status'=>'info'
                                        ];
                                    } else {
                                        $this->results[] = [
                                            'message'=>"Data untuk pelanggan ".$pelanggan->name." pada pemakaian ".$data['pemakaian_awal']." tidak di import karena sudah ada di database",
                                            'status'=>'warning'
                                        ];
                                    }
                                }
}
                            if($tanggal_penerimaan == null){
                                    $bulanIndexPenerimaan = array_search(strtoupper($tanggal_penerimaan_arr[1]),$bulanIndo);
                                    $tanggal_penerimaan = Carbon::parse($tanggal_penerimaan_arr[0]."-".$bulanIndexPenerimaan."-".$tanggal_penerimaan_arr[2]);
                                }
                            if($new_tagihan){
                                $tagihan = Tagihan::create([
                                    "id_tagihan" => $id_tagihan,
                                    "pelanggan_id" => $pelanggan->id,
                                    'tanggal' => $pemakaian_awal->format("Y-m-d"),
                                    'tanggal_akhir' => $pemakaian_akhir->format("Y-m-d"),
                                    'tanggal_penerimaan' => $tanggal_penerimaan->format("Y-m-d"),
                                    'meter_penggunaan_awal' => 0,
                                    'meter_penggunaan' => (int)$data['volume'],
                                    'jumlah_pembayaran' => (int)$data['pokok'],
                                    'tarif' => 0,
                                    'denda_harian' => (int)$data['denda'],
                                    'denda_admin' => 0,
                                    'file_name' => null,
                                    'file_path' => null,
                                    'pesan' => null,
                                    'status' => 2
                    
                                ]);

                                $number2 = rand(0, 1000);
                                $id_pembayaran = date("Ymdhis").''.$number2;
                                $pembayaran = Pembayaran::create([
                                    'id_pembayaran' => $id_pembayaran,
                                    'tagihan_id' => $tagihan->id,
                                    'tanggal' => $tanggal_penerimaan->format("Y-m-d"),
                                ]);
                                $number3 = rand(0, 1000);
                                $id_pelunasan = date("Ymdhis").''.$number3;
                                $pelunasan = Pelunasan::create([
                                    'id_pelunasan' => $id_pelunasan,
                                    'pembayaran_id' => $pembayaran->id,
                                    // 'tanggal' => date('Y-m-d'),
                                ]);
            
                                $target = Target::where("id_daerah", "=", $upt->id)->first();
                                if($target){
                                    $target->update(["realisasi" => $target->realisasi + (int)$data['pokok']]);
                                } else {
                                    $this->results[] = [
                                        'message'=>"Target untuk daerah ".$upt->nama_daerah." tidak ditemukan",
                                        'status'=>'warning'
                                    ];
                                }
                            }
                            
                            
        
                            
                        } else {
                            if(((isset($tanggal_penerimaan_arr[1]) && in_array(strtoupper($tanggal_penerimaan_arr[1]),$bulanIndo)) || $tanggal_penerimaan != null)){
                                if($pemakaian_akhir == null){
                                    $this->results[] = [
                                        'message'=>"Data gagal di import, format tanggal '".$data['pemakaian_akhir']."' untuk perusahaan ".$data['wajib_pajak']." tidak sesuai",
                                        'status'=>'danger'
                                    ];
                                } else {
                                    $this->results[] = [
                                        'message'=>"Data gagal di import, format tanggal '".$data['pemakaian_awal']."' untuk perusahaan ".$data['wajib_pajak']." tidak sesuai",
                                        'status'=>'danger'
                                    ];
                                }
                            } else {
                               
                                $this->results[] = [
                                    'message'=>"Data gagal di import, format tanggal '".$data['tanggal']."' untuk perusahaan ".$data['wajib_pajak']." tidak sesuai",
                                    'status'=>'danger'
                                ];
                            }
                            
                        }
                    } catch (\Throwable $th) {
                        $this->results[] = [
                            'message'=>$th->getMessage().". ".@$data['wajib_pajak'],
                            'status'=>'danger'
                        ];
                        
                    }
                    
                } else {
                    $this->results[] = [
                        'message'=>"Data gagal di import, Daerah ".$data['id_kota']."-".$data['kotakabupaten']." tidak ditemukan",
                        'status'=>'danger'
                    ];
                }
            }
            //jika memilih import data walaupun ada data lain yang tidak sesuai
            if(request()->import_data){
                DB::commit();
            }
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->results[] = [
                'message'=>$th->getMessage().". ".@$data['wajib_pajak'],
                'status'=>'danger'
            ];
        }
        //jika memilih tidak import data walaupun ada data lain yang tidak sesuai
        $error = false;
        foreach ($this->results as $result) {
            if($result['status'] == 'danger'){
                $error = true;
            }
        }
        if(!request()->import_data && !$error){
            DB::commit();
        }
    
    }
}
