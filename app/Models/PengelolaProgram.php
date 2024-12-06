<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengelolaProgram extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'nama', 'program', 'user_id', 'nip'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
