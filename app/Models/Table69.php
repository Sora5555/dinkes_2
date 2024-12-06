<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table69 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'difteri_l',
        'difteri_p',
        'difteri_lp',
        'difteri_m',
        'pertusis_l',
        'pertusis_p',
        'pertusis_lp',
        'tetanus_neonatorum_l',
        'tetanus_neonatorum_p',
        'tetanus_neonatorum_lp',
        'tetanus_neonatorum_m',
        'hepatitis_l',
        'hepatitis_p',
        'hepatitis_lp',
        'suspek_campak_l',
        'suspek_campak_p',
        'suspek_campak_lp',
        'status',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
