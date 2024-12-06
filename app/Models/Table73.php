<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table73 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'suspek',
        'mikroskopis',
        'rapid',
        'l_positif',
        'p_positif',
        'pengobatan_standar',
        'l_meninggal',
        'p_meninggal',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
