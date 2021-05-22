<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => 'HP',
            'description' => 'Hewlett-Packard',
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'DELL',
            'description' => 'Dell Inc.',
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'LENOVO',
            'description' => NULL,
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'RASPBERRY PI',
            'description' => 'Raspberry Pi Foundation',
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'SAT',
            'description' => NULL,
            'created_at' => now(),
        ]);
    }
}
