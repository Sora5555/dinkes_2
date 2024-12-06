<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelayananLansia extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah_L','jumlah_P', 'standar_L', 'standar_P', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
