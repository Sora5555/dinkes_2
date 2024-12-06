<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemangku extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama',
        'nip',
        'golongan_id',
        'jabatan_id',
    ];

    public function Jabatan(){
        return $this->belongsTo(Jabatan::class);
    }
    public function Golongan(){
        return $this->belongsTo(Golongan::class);
    }
}
