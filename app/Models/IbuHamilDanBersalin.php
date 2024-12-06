<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IbuHamilDanBersalin extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'sasaran_jumlah_ibu_hamil', 'sasaran_jumlah_ibu_bersalin', 'jumlah_ibu_hamil', 'jumlah_ibu_bersalin', 'k1', 'k4', 'k6', 'fasyankes', 'kf1', 'kf_lengkap', 'vita', 'status', 'td1', 'td2', 'td3', 'td4', 'td5', 'td2_plus', 'dapat_ttd', 'konsumsi_ttd', 'kondom', 'pil', 'suntik', 'mop', 'mow', 'akdr', 'implan', 'mal'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
