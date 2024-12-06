<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AngkaKematian extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama_rumah_sakit', 'jumlah_tempat_tidur', 'pasien_keluar_hidup_mati_L', 'pasien_keluar_hidup_mati_P', 'pasien_keluar_mati_L', 'pasien_keluar_mati_P', 'pasien_keluar_mati_48_L', 'pasien_keluar_mati_48_P', 'jumlah_hari_perawatan', 'jumlah_lama_dirawat'
    ];
}
