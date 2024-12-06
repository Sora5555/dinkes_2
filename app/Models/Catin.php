<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'kua_L', 'kua_P', 'layanan_L', 'layanan_P', 'anemia', 'gizi', 'status'
    ];
    
}
