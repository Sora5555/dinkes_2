<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObatEsensial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama', 'unit_kerja_id', 'status',
    ];

    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class);
    }
}
