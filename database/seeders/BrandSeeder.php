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
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'DELL',
            'created_at' => now(),
        ]);

        DB::table('brands')->insert([
            'name' => 'LENOVO',
            'created_at' => now(),
        ]);
    }
}
