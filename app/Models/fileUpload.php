<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fileUpload extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'file_name', 'file_path', 'user_id', 'year', 'menu', 'status'
    ];
    public function User(){
        return $this->belongsTo(User::class);
    }
}
