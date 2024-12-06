<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eselon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama',
    ];
    public function UnitOrganisasi(){
        return $this->hasMany(UnitOrganisasi::class);
    }
    public function Jabatan(){
        return $this->hasMany(Jabatan::class);
    }
}
