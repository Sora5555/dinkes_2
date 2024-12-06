<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorOpd extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'nama',
        'parameter',
        'satuan',
        'kondisi_awal',
        'keterangan',
        'sasaran_renstra_id',
        'target_kerja',
        'capaian_satu',
        'capaian_dua',
        'capaian_tiga',
        'capaian_empat',
        'berkualitas',
    ];


    public function detailProgram(){
        return $this->hasMany(detailProgram::class);
    }
}
