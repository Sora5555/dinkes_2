<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KesehatanBalita extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id','balita_0_59', 'balita_12_59', 'balita_kia', 'balita_dipantau', 'balita_sdidtk', 'balita_mtbs', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
