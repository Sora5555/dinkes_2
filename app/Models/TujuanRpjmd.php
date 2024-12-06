<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TujuanRpjmd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'misi_rpjmd_id',
    ];

    public function Misi(){
        return $this->belongsTo(MisiRpjmd::class);
    }
    public function Sasaran(){
        return $this->hasMany(SasaranRpjmd::class);
    }
}
