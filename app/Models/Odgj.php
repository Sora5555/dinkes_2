<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odgj extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skizo_0', 'skizo_15', 'skizo_60', 'psiko_0', 'psiko_15', 'psiko_60', 'sasaran', 'desa_id', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
