<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggans';
    protected $fillable=[
        'no_pelanggan',
        'name',
        'no_telepon',
        'daerah_id',
        'kategori_industri_id',
        'nik',
        'alamat',
        'user_id',
        'lokasi',
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function tagihan_pemasangan()
    {
        return $this->hasMany(TagihanPemasangan::class);
    }

    public function kategori_npa()
    {
        return $this->belongsTo(KategoriNPA::class,'kategori_industri_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function pelunasan(){
        return $this->hasMany(Pelunasan::class);
    }
    public function daerah(){
        return $this->belongsTo(UptDaerah::class,'daerah_id');
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($q) {
             $q->tagihan()->each(function($q1) {
                $q1->delete();
             });
        });
    }

    public function getNoPerusahaanAttribute()
    {
        return sprintf("%02d", $this->daerah_id).sprintf("%06d", $this->id);
    }
    public function getJumlahAttribute(){
        $total = 0;
        foreach ($this->tagihan as $key => $tagihan) {
            # code...
             $total += $tagihan->jumlah_pembayaran;
        }
        return $total;
    }
}