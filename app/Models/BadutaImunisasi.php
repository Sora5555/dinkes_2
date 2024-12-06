<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadutaImunisasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah_L', 'jumlah_P', 'dpt_L', 'dpt_P', 'rubela_L', 'rubela_P', 'status'
    ];
}
