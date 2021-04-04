<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('hdds')->insert([
            'size' => 'NO APLICA',
            'type' => 'NO APLICA',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '70 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '70 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '100 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '100 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '120 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '120 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '150 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '150 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '150 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '150 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '200 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '200 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '250 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '250 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '300 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '300 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '500 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '500 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '800 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '800 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '1 TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '1 TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '2 TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '2 TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '120 SSD',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '120 SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '256 SSD',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '256 SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '500 SSD',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('hdds')->insert([
            'size' => '500 SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);
    }
}
