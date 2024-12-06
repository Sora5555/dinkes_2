<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pus extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah', 'kondom', 'akdr', 'pil', 'suntik', 'implan', 'mop', 'mow', 'mal', 'efek_samping', 'komplikasi', 'kegagalan', 'dropout', 'pus_4_t', 'pus_4_t_kb', 'pus_alki', 'pus_alki_kb', 'status'
    ];
}
