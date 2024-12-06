<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndikatorKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'nama',
        'sasaran_kegiatan_id',
    ];
    public function Sasaran(){
        return $this->belongsTo(Sasarankegiatan::class);
    }
}
