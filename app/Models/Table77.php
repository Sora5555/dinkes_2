<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table77 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'kegiatan_deteksi',
        'perempuan_30_50_tahun',
        'jumlah_iva',
        'jumlah_sadanis',
        'jumlah_iva_positif',
        'jumlah_curiga',
        'jumlah_krioterapi',
        'jumlah_iva_positif_dan_curiga_kanker_leher',
        'jumlah_tumor',
        'jumlah_kanker_payudara',
        'jumlah_tumor_curiga_kanker_payudara_dirujuk',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
