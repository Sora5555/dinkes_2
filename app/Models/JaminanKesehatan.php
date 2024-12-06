<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JaminanKesehatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama_kepesertaan', 'golongan', 'jumlah',
    ];

}
