<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table66 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id', 'pausi_anak',
        'pausi_dewasa',
         'multi_anak',
        'multi_dewasa',
        'status',
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }

}
