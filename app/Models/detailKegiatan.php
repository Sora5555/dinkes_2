<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'detail_program_id',
        'kegiatan_id',
        'nama_kegiatan',
        'jabatan_id',
        'nama_jabatan',
        'pagu_anggaran',
        'tw_1',
        'tw_2',
        'tw_3',
        'tw_4'
    ];
    public function detailIndikatorKegiatan(){
        return $this->hasMany(detailIndikatorKegiatan::class);
    }
    public function detailSubKegiatan(){
        return $this->hasMany(detailSubKegiatan::class);
    }
}
