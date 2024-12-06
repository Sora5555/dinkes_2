<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JumlahKematianIbu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'jumlah_kematian_ibu_hamil', 'jumlah_kematian_ibu_bersalin', 'jumlah_kematian_ibu_nifas', 'status',
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
