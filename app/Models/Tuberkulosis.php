<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tuberkulosis extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'unit_kerja_id','terduga_kasus', 'kasus_L', 'kasus_P', 'kasus_anak', 'kasus_LP', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
