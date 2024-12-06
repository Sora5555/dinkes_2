<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table74 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'kronis_t_sebelumnya_l',
        'kronis_t_sebelumnya_p',
        'kronis_b_ditemukan_l',
        'kronis_b_ditemukan_p',
        'kronis_pindah_l',
        'kronis_pindah_p',
        'kronis_meninggal_l',
        'kronis_meninggal_p',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
