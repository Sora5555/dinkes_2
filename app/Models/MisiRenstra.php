<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MisiRenstra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nama',
        'visi_renstra_id',
    ];

    public function Visi(){
        return $this->belongsTo(VisiRenstra::class);
    }
}
