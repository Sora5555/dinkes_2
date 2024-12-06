<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gigi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'kunjungan', 'pencabutan', 'tumpatan', 'rujukan', 'kasus', 'status'
    ];
}
