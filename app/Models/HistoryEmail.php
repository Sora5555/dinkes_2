<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryEmail extends Model
{
    use HasFactory;
    protected $fillable = ['pelanggan_id','template_email_id'];
}
