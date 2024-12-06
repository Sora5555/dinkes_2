<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'kode',
        'full_kode',
        'uraian',
        'induk_opd_id'
    ];

    public function Sasaran(){
        return $this->hasMany(SasaranProgram::class);
    }
    public function detailProgram(){
        return $this->hasMany(detailProgram::class);
    }
}
