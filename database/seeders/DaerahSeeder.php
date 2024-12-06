<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UptDaerah;

class DaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Samarinda',
            'Sangatta',
            'Balikpapan',
            'Bontang',
            'Tarakan',
            'Nunukan',
            'Pasir',
            'Tenggarong',
        ];

        if (!UptDaerah::count() > 0) {
            foreach ($data as $value) {
                UptDaerah::create(['nama_daerah'=>$value]);
            }
        }
    }
}
