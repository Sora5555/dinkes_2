<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanPemasangan extends Model
{
    use HasFactory;

    protected $fillable =['id_tagihan_pemasangan','pelanggan_id','tanggal','jumlah_pembayaran','tipe_pembayaran'];

    protected $dates = ['tanggal'];

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class);
    }

    public function pembayaran(){
        return $this->hasMany(PembayaranPemasangan::class);
    }

    public function getStatusAttribute(){
        $jumlah = $this->pembayaran->sum('jumlah_pembayaran');

        if($jumlah < $this->jumlah_pembayaran){
            return "Belum Lunas";
        }else if($jumlah >= $this->jumlah_pembayaran){
            return "Sudah Lunas";
        }else{
            return "Belum Lunas";
        }
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($q) {
             $q->pembayaran()->each(function($q1) {
                $q1->delete();
             });

        });
    }
}
