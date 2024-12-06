<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelahiran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'lahir_hidup_L', 'lahir_mati_L', 'lahir_hidup_P', 'lahir_mati_P', 'status',
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
