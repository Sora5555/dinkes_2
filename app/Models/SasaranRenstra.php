<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranRenstra extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'nama',
        'tujuan_renstra_id',
        'induk_opd_id',
        'indikator_pemerintah_id',
        'sasaran_hasil',
    ];

    public function Tujuan(){
        return $this->belongsTo(TujuanRenstra::class);
    }
    public function indikatorOpd(){
        return $this->hasMany(IndikatorOpd::class);
    }
    public function indikatorPemerintah(){
        return $this->belongsTo(IndikatorPemerintah::class);
    }
}
