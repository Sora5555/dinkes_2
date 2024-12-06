<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Golongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
    ];

    public function Pemangku(){
        return $this->hasMany(Pemangku::class);
    }
}
