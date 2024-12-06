<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisiRenstra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'induk_opd_id',
    ];

    public function IndukOpd(){
        return $this->belongsTo(IndukOpd::class);
    }
    public function Misi(){
        return $this->hasMany(MisiRenstra::class);
    }
}
