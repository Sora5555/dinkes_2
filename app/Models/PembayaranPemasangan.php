<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranPemasangan extends Model
{
    use HasFactory;
    
    protected $fillable=['id_pembayaran_pemasangan','tagihan_pemasangan_id','jumlah_pembayaran'];

    protected $dates = ['created_at'];

    public function tagihan_pemasangan(){
        return $this->belongsTo(TagihanPemasangan::class);
    }
}
