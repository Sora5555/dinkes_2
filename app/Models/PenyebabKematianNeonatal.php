<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyebabKematianNeonatal extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'bblr', 'kelainan', 'asfiksia', 'tetanus', 'infeksi', 'covid_19', 'cardio', 'lain_lain_neo', 'perinatal', 'pneumonia', 'diare', 'jantung', 'kelainan_kongenital', 'meningitis', 'saraf', 'dbd', 'lain_lain_post_neo', 'status'
    ];
}
