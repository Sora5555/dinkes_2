<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GigiAnak extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'jumlah_sikat', 'jumlah_yan', 'jumlah_sd', 'sd_L', 'sd_P', 'diperiksa_L', 'diperiksa_P', 'rawat_L', 'rawat_P', 'dapat_L', 'dapat_P', 'status'
    ];
    
}
