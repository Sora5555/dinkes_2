<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'kode',
        'full_kode',
        'uraian',
        'induk_opd_id',
        'kegiatan_id',
        'pagu_indikatif',
        'rp_tri_1',
        'rp_tri_2',
        'rp_tri_3',
        'rp_tri_4',
    ];

    public function detailSubKegiatan(){
        return $this->hasMany(detailSubKegiatan::class);
    }

    public function Sasaran(){
        return $this->hasMany(SasaranSubKegiatan::class);
    }
}
