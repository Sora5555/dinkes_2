<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranRpjmd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'tujuan_rpjmd_id',
    ];
    
    public function Tujuan(){
        return $this->belongsTo(TujuanRpjmd::class);
    }
    public function TujuanRenstra(){
        return $this->hasMany(TujuanRenstra::class);
    }
    public function IndikatorPemerintah(){
        return $this->hasMany(IndikatorPemerintah::class);
    }
}
