<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NPA extends Model
{
    use HasFactory;

    protected $table = 'npa';
    protected $fillable = ['harga','volume_awal','volume_akhir','kategori_id'];

    public function wilayah(){
        return $this->belongsToMany(UptDaerah::class,'npa_wilayah','wilayah_id','npa_id');
    }

    public function kategori(){
        return $this->belongsTo(KategoriNPA::class);
    }
}
