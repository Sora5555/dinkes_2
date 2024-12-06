<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelunasan extends Model
{
    use HasFactory;

    protected $fillable=['id_pelunasan','pembayaran_id'];

    protected $dates = ['tanggal','created_at'];

    public function pembayaran(){
        return $this->belongsTo(Pembayaran::class);
    }
}
