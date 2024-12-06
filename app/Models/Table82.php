<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table82 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'sd',
        'smp',
        'puskesmas',
        'pasar',
        'm_sd',
        'm_smp',
        'm_puskesmas',
        'm_pasar',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
