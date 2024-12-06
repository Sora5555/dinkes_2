<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JumlahPenduduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kelompok_umur', 'laki_laki', 'perempuan',
    ];
}
