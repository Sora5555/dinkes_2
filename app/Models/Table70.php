<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table70 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'jumlah',
        'ditangani_24',
        'status'
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
