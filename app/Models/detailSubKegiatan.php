<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detailSubKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'detail_kegiatan_id',
        'sub_kegiatan_id',
        'nama_sub_kegiatan',
        'jabatan_id',
        'nama_jabatan',
    ];
    public function subKegiatan(){
        return $this->belongsTo(SubKegiatan::class);
    }
    public function detailIndikatorSubKegiatan(){
        return $this->hasMany(DetailIndikatorSubKegiatan::class);
    }
}
