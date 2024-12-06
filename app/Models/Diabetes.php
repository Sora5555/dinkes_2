<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diabetes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jumlah', 'pelayanan', 'desa_id', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
