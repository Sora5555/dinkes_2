<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hipertensi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'jumlah_L', 'jumlah_P','pelayanan_L', 'pelayanan_P', 'desa_id', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
