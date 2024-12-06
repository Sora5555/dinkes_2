<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lunas extends Model
{
    use HasFactory;
    protected $fillable = ['awalan_surat', 'daerah_id', 'tahun', 'urutan', 'kode_wilayah'];

    public function daerah(){
        return $this->belongsTo(UptDaerah::class, 'daerah_id');
    }
}
