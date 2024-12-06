<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kunjungan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jalan_L', 'jalan_P', 'inap_L', 'inap_P', 'jiwa_L', 'jiwa_P', 'unit_kerja_id', 'desa_id', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
