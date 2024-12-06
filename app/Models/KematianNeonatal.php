<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KematianNeonatal extends Model
{
    use HasFactory, SoftDeletes;
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'neo_L', 'post_neo_L', 'balita_L', 'neo_P', 'post_neo_P', 'balita_P', 'status'
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
