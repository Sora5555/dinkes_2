<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'sasaran_program_id',
    ];
    public function Sasaran(){
        return $this->belongsTo(SasaranProgram::class);
    }
}
