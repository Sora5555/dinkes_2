<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BayiImunisasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'dpt_L', 'dpt_P', 'rubela_L', 'rubela_P', 'polio_L', 'polio_P', 'lengkap_L', 'lengkap_P', 'status'
    ];
}
