<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TujuanRenstra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'misi_rpjmd_id',
        'misi_renstra_id',
        'induk_opd_id'
    ];
    
    public function Sasaran(){
        return $this->belongsTo(SasaranRpjmd::class);
    }

    public function SasaranRenstra(){
        return $this->hasMany(SasaranRenstra::class);
    }
}

