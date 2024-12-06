<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusGizi extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah_timbang', 'bb_kurang', 'jumlah_tinggi', 'tb_kurang', 'jumlah_gizi', 'gizi_kurang', 'gizi_buruk', 'status'
    ];
}
