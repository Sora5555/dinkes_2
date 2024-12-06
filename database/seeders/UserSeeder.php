<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::whereHas('roles',function($query){
            $query->where('name','Admin');
        })->count() > 0) {
            $user = User::create([
                'name'=>'Admin',
                'email'=>'admin@mail.com',
                'password'=>\Hash::make('12345678'),
            ]);

            $user->assignRole('Admin');
        }
    }
}
