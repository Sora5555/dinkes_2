<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table84 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'kasus',
        'sembuh',
        'meninggal',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
