<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama_menu', 'nama_filter', 'atribut_L', 'atribut_P', 'atribut_LP', 'satuan',
    ];
}
