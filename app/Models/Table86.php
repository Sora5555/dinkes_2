<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table86 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'sasaran_6_11',
        'hasil_vaksinasi_6_11',
        'sasaran_12_17',
        'hasil_vaksinasi_12_17',
        'sasaran_18_59',
        'hasil_vaksinasi_18_59',
        'sasaran_60_up',
        'hasil_vaksinasi_60_up',
        
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
