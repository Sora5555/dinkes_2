<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_perusahaan',
        'email',
        'password',
        'kategori_npa',
        'id_wilayah',
        'no_telp',
        'alamat',
        'date',
        'alasan'
    ];
    public function daerah(){
        return $this->belongsTo(UptDaerah::class,'id_wilayah');
    }
    public function kategori(){
        return $this->belongsTo(KategoriNPA::class,'kategori_npa');
    }
}
