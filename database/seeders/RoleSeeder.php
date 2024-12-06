<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            'Admin',
            'Pihak Wajib Pajak',
            'Operator',
        ];

        if (!Role::count() > 0) {
            foreach ($role as $key => $value) {
                Role::create([
                    'name'=>$value,
                    'guard_name'=>'web',
                ]);
            }
        }
    }
}
