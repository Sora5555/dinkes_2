<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitOrganisasi extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nama', 'induk_opd_id', 'eselon_id'
    ];

    public function eselon(){
        return $this->belongsTo(Eselon::class);
    }
}
