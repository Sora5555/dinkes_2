<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table68 extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id', 'jumlah_kasus_afp',
        'jumlah_penduduk_15',
        'status',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
