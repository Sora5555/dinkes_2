<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'program_id',
    ];
     
    public function Program(){
        return $this->belongsTo(Program::class);
    }
    public function Indikator(){
        return $this->hasMany(IndikatorProgram::class);
    }
}
