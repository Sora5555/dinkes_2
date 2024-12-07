<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokterGigiSpesialis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'laki_laki', 'perempuan', 'unit_kerja_id'
    ];
    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class);
    }

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
