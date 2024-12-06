<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table67 extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'desa_id', 'kusta_2022_rft',
        'kusta_2022_baru',
         'kusta_2021_baru',
        'kusta_2021_rft',
        'status'
    ];

    public function Desa(){
        return $this->belongsTo(Desa::class);
    }
}
