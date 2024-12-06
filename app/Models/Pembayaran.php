<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    
    protected $fillable=['id_pembayaran','tagihan_id','tanggal', 'file_name', 'file_path'];

    protected $dates = ['tanggal','created_at'];

    public function tagihan(){
        return $this->belongsTo(Tagihan::class);
    }

    public function pelunasan(){
        return $this->hasOne(Pelunasan::class);
    }
}
