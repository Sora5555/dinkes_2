<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MisiRpjmd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'visi_rpjmd_id',
    ];

    public function visi(){
        return $this->belongsTo(visiRpjmd::class);
    }
    public function tujuan(){
        return $this->hasMany(TujuanRpjmd::class);
    }
}
