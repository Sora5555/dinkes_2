<?php

namespace App\Models;

use App\Http\Controllers\PemangkuController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes, HasRecursiveRelationships;
    protected $table = 'jabatans';
    protected $fillable =[
        'nama',
        'level',
        'bezetting',
        'induk_opd_id',
        'jenis_jabatan_id',
        'unit_organisasi_id',
        'induk_jabatan_id',
    ];

   public function UnitOrganisasi(){
    return $this->belongsTo(UnitOrganisasi::class);
   }
   public function JenisJabatan(){
    return $this->belongsTo(JenisJabatan::class);
   }
   public function IndukOpd(){
    return $this->belongsTo(IndukOpd::class);
   }
   public function Pemangku(){
    return $this->hasOne(Pemangku::class);
   }
   public function getParentKeyName()
    {
        return 'induk_jabatan_id';
    }
}
