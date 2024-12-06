<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['alamat',
    'harga_per_kubik',
    'harga_pemasangan',
    'harga_pemasangan_dp',
    'template_pesan_id',
    'template_pesan_terlambat_id',
    'template_pesan_terlambat_manager_id'];
}
