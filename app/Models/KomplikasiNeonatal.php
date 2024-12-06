<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KomplikasiNeonatal extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'bblr', 'asfiksia', 'tetanus', 'kelainan', 'lain_lain', 'covid_19', 'infeksi', 'status'
    ];
}
