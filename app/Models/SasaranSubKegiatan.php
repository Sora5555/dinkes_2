<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranSubKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'sub_kegiatan_id',
    ];

    public function SubKegiatan(){
        return $this->belongsTo(SubKegiatan::class);
    }
    public function Indikator(){
        return $this->hasMany(IndikatorSubKegiatan::class);
    }
}
