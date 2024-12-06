<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neonatal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'kn1_L', 'kn1_P', 'kn_lengkap_L', 'kn_lengkap_P', 'hipo_L', 'hipo_P', 
        'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
