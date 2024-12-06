<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPesan extends Model
{
    use HasFactory;

    protected $fillable = ['pelanggan_id','template_pesan_id'];
}
