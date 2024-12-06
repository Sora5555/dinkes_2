<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class DeteksiDiniHepatitisBPadaIbuHamil extends Model
{
    use HasFactory;

    protected $fillable = [
        'desa_id', 'jumlah_ibu_hamil', 'reaktif', 'non_reaktif', 'status'
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }

    public function IbuHamil($id) {
        $ibuHamil = IbuHamilDanBersalin::where('desa_id', $id)->whereYear('created_at', Session::get('year'))->first();

        return $ibuHamil->jumlah_ibu_hamil;
    }

}
