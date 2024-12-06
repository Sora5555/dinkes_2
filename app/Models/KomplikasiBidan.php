<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KomplikasiBidan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah', 'kek', 'anemia', 'pendarahan', 'preklampsia', 'malaria', 'tuberkulosis', 'infeksi_lain', 'diabetes', 'jantung', 'covid_19', 'penyebab_lain', 'komplikasi_hamil', 'komplikasi_persalinan', 'komplikasi_nifas', 'status'
    ];
}
