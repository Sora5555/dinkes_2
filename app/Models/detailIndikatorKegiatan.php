<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailIndikatorKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'detail_kegiatan_id',
        'sasaran_kegiatan_id',
        'nama_sasaran_kegiatan',
        'indikator_kegiatan_id',
        'nama_indikator_kegiatan',
        'target_indikator',
        'kondisi_awal'
    ];
}
