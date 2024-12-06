<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table63 extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa_id', 'jumlah_bayi', 'jumlah_k_24', 'jumlah_b_24', 'status',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
