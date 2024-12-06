<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorPemerintah extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'nama',
        'induk_opd_id',
        'parameter',
        'satuan',
        'kondisi_awal',
        'keterangan',
        'sasaran_rpjmd_id',
        'merujuk_renstra',
        'target_kerja',
        'capaian_satu',
        'capaian_dua',
        'capaian_tiga',
        'capaian_empat',
        'berkualitas',
        'iku'
    ];
    public function IndukOpd(){
        return $this->belongsTo(IndukOpd::class);
    }
    public function SasaranRpjmd(){
        return $this->belongsTo(SasaranRpjmd::class);
    }
    public function detailProgram(){
        return $this->hasMany(detailProgram::class);
    }
}
