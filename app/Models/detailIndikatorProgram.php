<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailIndikatorProgram extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'detail_program_id',
        'sasaran_program_id',
        'nama_sasaran_program',
        'indikator_program_id',
        'nama_indikator_program',
        'target_indikator',
        'kondisi_awal',
    ];
}
