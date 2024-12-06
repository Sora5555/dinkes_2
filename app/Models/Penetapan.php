<?php

namespace App\Models;

use App\Models\UptDaerah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penetapan extends Model
{
    use HasFactory;
    protected $fillable = ['awalan_surat', 'daerah_id', 'tahun', 'urutan', 'kode_wilayah'];

    public function daerah(){
        return $this->belongsTo(UptDaerah::class, 'daerah_id');
    }
}
