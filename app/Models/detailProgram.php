<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailProgram extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'indikator_pemerintah_id',
        'indikator_opd_id',
        'nama_program',
        'program_id',
        'nama_jabatan',
        'jabatan_id',
    ];
    public function detailIndikatorProgram(){
        return $this->hasMany(detailIndikatorProgram::class);
    }
    public function detailKegiatan(){
        return $this->hasMany(detailKegiatan::class);
    }
}
