<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriNPA extends Model
{
    use HasFactory;

    protected $table = 'kategori_npa';
    protected $fillable = ['kategori', 'keterangan', 'sektor', 'periode_start', 'periode_end', 'aktif'];

    public function npa(){
        return $this->hasMany(NPA::class,'kategori_id');
    }

    public function pelanggan(){
        return $this->hasMany(Pelanggan::class,'kategori_industri_id');
    }
    public function antrian(){
        return $this->hasMany(Antrian::class, "kategori_npa_id");
    }

    public function getJumlahAttribute(){
        $total = 0;
        foreach ($this->pelanggan as $key => $pelanggan) {
            # code...
            $total +=  $pelanggan->jumlah;
        }
        return $total;
    }
}
