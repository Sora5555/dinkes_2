<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NpaWilayah extends Model
{
    use HasFactory;

    protected $table = 'npa_wilayah';
    protected $fillable = ['kategori','wilayah_id'];
    public $timestamps = false;
}
