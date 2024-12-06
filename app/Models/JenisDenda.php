<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDenda extends Model
{
    use HasFactory;

    protected $table = 'jenis_denda';
    protected $fillable = ['type','tanggal_jt','jenis_pengali','nominal_denda'];
}
