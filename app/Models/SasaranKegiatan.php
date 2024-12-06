<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'kegiatan_id',
    ];

    public function Kegiatan(){
        return $this->belongsTo(Kegiatan::class);
    }
    public function Indikator(){
        return $this->hasMany(IndikatorKegiatan::class);
    }
}
