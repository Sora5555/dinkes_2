<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndukOpd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'status',
        'kd_perangkat_daerah'
    ];

    public function Renstra(){
        return $this->hasMany(VisiRenstra::class);
    }
    public function IndikatorPemerintah(){
        return $this->hasMany(IndikatorPemerintah::class);
    }
}
