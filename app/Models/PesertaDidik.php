<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaDidik extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'jumlah_kelas_1','pelayanan_kelas_1', 'jumlah_kelas_7', 'pelayanan_kelas_7', 'jumlah_kelas_10', 'pelayanan_kelas_10', 'jumlah_usia_dasar', 'pelayanan_usia_dasar', 'jumlah_sd', 'pelayanan_sd', 'jumlah_smp', 'pelayanan_smp', 'jumlah_sma', 'pelayanan_sma', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
