<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'hamil', 'jumlah', 'td1', 'td2', 'td3', 'td4', 'td5', 'status'
    ];
}
