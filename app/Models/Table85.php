<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table85 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id',
        'l_0_4',
        'p_0_4',
        'l_5_6',
        'p_5_6',
        'l_7_14',
        'p_7_14',
        'l_15_59',
        'p_15_59',
        'l_60_up',
        'p_60_up',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
