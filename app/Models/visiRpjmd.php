<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class visiRpjmd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'tahun_awal',
        'tahun_akhir',
    ];

    public function Misi(){
        return $this->hasMany(MisiRpjmd::class);
    }
}
