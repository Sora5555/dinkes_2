<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odhiv extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'baru', 'arv', 'status',
    ];
}
