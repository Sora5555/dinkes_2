<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class Table65 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id', 'jumlah_cacat_0',
        'jumlah_cacat_1',
         'penderita_kusta_1',
        'penderita_kusta_2',
        'status',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }

    public function PenderitaKusta($id) {
        $PenderitaKusta = Table64::where('desa_id', $id)->whereYear('created_at', Session::get('year'))->first();
        // dd($id, $PenderitaKusta);

        return $PenderitaKusta->l_pb + $PenderitaKusta->p_pb + $PenderitaKusta->l_mb + $PenderitaKusta->p_mb;
    }
}
