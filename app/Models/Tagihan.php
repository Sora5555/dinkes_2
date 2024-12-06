<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tagihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tagihans';
    protected $fillable =['id_tagihan','pelanggan_id','tanggal','meter_penggunaan','meter_penggunaan_awal','jumlah_pembayaran','tarif','file_name','file_path','denda_harian','denda_admin','pesan','status', 'tanggal_penerimaan', 'tanggal_akhir',
    'nomor_surat_tagihan',
    'nomor_surat_penetapan',
    'nomor_surat_setoran',
    'jabatan_id',
    'jabatan_id2',
    'jabatan_id3',
    'waktu_token',
    'metode',
    'qris',
    'kd_tagihan',
    ];

    protected $dates = ['tanggal'];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }
    public function Jabatan(){
        return $this->belongsTo(Jabatan::class);
    }
    public function Jabatan2(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id2');
    }
    public function Jabatan3(){
        return $this->belongsTo(Jabatan::class, 'jabatan_id3');
    }

    public function pembayaran(){
        return $this->hasOne(Pembayaran::class);
    }

    // public function getStatusAttribute($value){
    //     // $jumlah = $this->pembayaran->count();

    //     // if($jumlah <= 0){
    //     //     return "Belum Lunas";
    //     // }else if($jumlah > 0){
    //     //     return "Sudah Lunas";
    //     // }else{
    //     //     return "Belum Lunas";
    //     // }
    //     if ($value == 0) {
    //         return "Belum diverifikasi";
    //     }elseif($value == 1){
    //         return "Sudah diverifikasi";
    //     }elseif($value == 2){
    //         return "Lunas";
    //     }

    // }

   

    public static function boot() {
        parent::boot();
        self::deleting(function($q) {
             $q->pembayaran()->each(function($q1) {
                $q1->delete();
             });

        });
    }
}