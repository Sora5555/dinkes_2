<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokUmur extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'batas_bawah', 'batas_atas', 'laki_laki', 'perempuan',
    ];
}
