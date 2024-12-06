<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table71 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'jenis_kejadian',
        'jumlah_kec',
        'jumlah_desa',
        'diketahui',
        'ditanggulangi',
        'akhir',
        'l_pen',
        'p_pen',
        '0_7_hari',
        '8_28_hari',
        '1_11_bulan',
        '1_4_tahun',
        '5_9_tahun',
        '15_19_tahun',
        '20_44_tahun',
        '45_54_tahun',
        '55_59_tahun',
        '60_69_tahun',
        '70_plus_tahun',
        'l_mati',
        'p_mati',
        'l_penduduk',
        'p_penduduk',
    ];
}
