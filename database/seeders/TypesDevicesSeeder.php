<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesDevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_devices')->insert([
            'name' => 'DE ESCRITORIO',
            'created_at' => now(),
        ]);

        DB::table('type_devices')->insert([
            'name' => 'TURNERO',
            'created_at' => now(),
        ]);

        DB::table('type_devices')->insert([
            'name' => 'PORTATIL',
            'created_at' => now(),
        ]);

        DB::table('type_devices')->insert([
            'name' => 'RASPBERRY',
            'created_at' => now(),
        ]);

        DB::table('type_devices')->insert([
            'name' => 'ALL IN ONE',
            'created_at' => now(),
        ]);

        DB::table('type_devices')->insert([
            'name' => 'TELEFONO IP',
            'created_at' => now(),
        ]);
    }
}
