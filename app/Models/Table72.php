<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table72 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'l_kasus',
        'p_kasus',
        'l_meninggal',
        'p_meninggal',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
