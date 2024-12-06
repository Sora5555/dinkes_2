<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObatTuberkulosis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'konfirmasi_L', 'konfirmasi_P', 'diobati_L', 'diobati_P', 'kesembuhan_L', 'kesembuhan_P', 'lengkap_L', 'lengkap_P', 'berhasil_L', 'berhasil_P', 'kematian', 'status'
    ];
    
}
