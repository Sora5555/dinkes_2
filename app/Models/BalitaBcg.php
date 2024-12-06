<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalitaBcg extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'duaempat_jam_L', 'duaempat_jam_P', 'satu_minggu_L', 'satu_minggu_P', 'bcg_L', 'bcg_P', 'status',
    ];
}
