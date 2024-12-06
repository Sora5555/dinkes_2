<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BblrPrematur extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'desa_id', 'timbang_L', 'timbang_P', 'bblr_L', 'bblr_P', 'prematur_L', 'prematur_P', 'status'
    ];
}
