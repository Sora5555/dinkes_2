<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalitaVita extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'jumlah_6', 'vita_6', 'jumlah_12', 'vita_12', 'status'
    ];
}
