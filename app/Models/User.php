<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'username',
        'password',
        'kode_skpd',
        'induk_opd_id',
        'level_id',
        'kategori_opd_id',
        'alamat',
        'unit_kerja_id',
        'nip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }

    public function PengelolaProgram(){
        return $this->hasMany(PengelolaProgram::class);
    }
    public function menuPermission(){
        return $this->hasMany(MenuPermission::class);
    }
    public function fileUpload(){
        return $this->hasMany(fileUpload::class);
    }

     public function IndukOpd(){
        return $this->belongsTo(IndukOpd::class);
    }
     public function unit_kerja(){
        return $this->belongsTo(UnitKerja::class);
    }

    public function hasRoles($roles)
    {
    return in_array($this->roles->first()->name, (array) $roles);
    }

    public function hasMenuPermission($menuId)
    {
    return $this->menuPermission->contains('menu_id', $menuId);
    }
    public function hasFile($menu_name, $year)
    {
        return $this->fileUpload->contains(function ($permission) use ($menu_name, $year) {
            return $permission->menu == $menu_name && $permission->year == $year;
        });
    }
    public function downloadFile($menu_name, $year)
    {
        return $this->fileUpload->where('menu', $menu_name)->where('year', $year)->first();
    }
   
}
