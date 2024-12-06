<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'kode',
        'full_kode',
        'uraian',
        'induk_opd_id',
        'program_id',
    ];

    public function Program(){
        return $this->belongsTo(Program::class);
    }
    public function detailKegiatan(){
        return $this->hasMany(detailKegiatan::class);
    }

    public function Sasaran(){
        return $this->hasMany(SasaranKegiatan::class);
    }
}
