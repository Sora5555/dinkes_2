<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyebabKematianIbu extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'desa_id', 'perdarahan', 'gangguan_hipertensi', 'infeksi', 'kelainan_jantung', 'gangguan_autoimun', 'gangguan_cerebro', 'covid_19', 'abortus', 'lain_lain', 'status'
    ];
    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
