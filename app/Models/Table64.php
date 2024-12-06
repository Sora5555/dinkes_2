<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table64 extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa_id', 'l_pb', 'p_pb', 'l_mb', 'p_mb', 'status'
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
