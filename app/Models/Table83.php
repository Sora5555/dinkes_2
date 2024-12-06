<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table83 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'jasa_boga_terdaftar',
        'jasa_boga_jumlah',
        'restoran_terdaftar',
        'restoran_jumlah',
        'tpp_tertentu_terdaftar',
        'tpp_tertentu_jumlah',
        'depot_air_minum_terdaftar',
        'depot_air_minum_jumlah',
        'rumah_makan_terdaftar',
        'rumah_makan_jumlah',
        'kelompok_gerai_terdaftar',
        'kelompok_gerai_jumlah',
        'sentra_pangan_terdaftar',
        'sentra_pangan_jumlah',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
