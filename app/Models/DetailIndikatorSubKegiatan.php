<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailIndikatorSubKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'detail_sub_kegiatan_id',
        'sasaran_sub_kegiatan_id',
        'nama_sasaran_sub_kegiatan',
        'indikator_sub_kegiatan_id',
        'nama_indikator_sub_kegiatan',
        'target_indikator',
        'kondisi_awal'
    ];
}
