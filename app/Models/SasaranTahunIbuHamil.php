<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranTahunIbuHamil extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'sasaran_jumlah_ibu_hamil',
        'sasaran_januari', 
        'capaian_januari',
        'status_januari',
        'sasaran_februari', 
        'capaian_februari',
        'status_februari',
        'sasaran_maret', 
        'capaian_maret',
        'status_maret',
        'sasaran_april', 
        'capaian_april',
        'status_april',
        'sasaran_mei', 
        'capaian_mei',
        'status_mei',
        'sasaran_juni', 
        'capaian_juni',
        'status_juni',
        'sasaran_juli', 
        'capaian_juli',
        'status_juli',
        'sasaran_agustus', 
        'capaian_agustus',
        'status_agustus',
        'sasaran_september', 
        'capaian_september',
        'status_september',
        'sasaran_oktober', 
        'capaian_oktober',
        'status_oktober',
        'sasaran_november', 
        'capaian_november',
        'status_november',
        'sasaran_desember', 
        'capaian_desember',
        'status_desember',
        'desa_id'
    ];

    public function total_capaian(){
        $var = $this->capaian_januari + $this->capaian_februari + $this->capaian_maret + $this->capaian_april + $this->capaian_mei + $this->capaian_juni + $this->capaian_juli + $this->capaian_agustus + $this->capaian_september + $this->capaian_oktober + $this->capaian_november + $this->capaian_desember;
        // dd($this);
        return $var;
    }
}
