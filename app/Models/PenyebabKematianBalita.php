<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyebabKematianBalita extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'pneumonia', 'kelainan_kongenital', 'kongenital_lain', 'saraf', 'dbd', 'jantung', 'lakalantas', 'tenggelam', 'infeksi', 'lain_lain', 'status'
    ];
}
