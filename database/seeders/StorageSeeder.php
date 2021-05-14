<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('storages')->insert([
            'size' => 'NO APLICA',
            'type' => 'NO APLICA',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '70 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '70 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '100 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '100 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '120 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '120 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '150 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '150 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '200 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '200 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '250 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '250 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '300 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '300 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '500 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '500 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '800 GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '800 GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '1 TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '1 TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '2 TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '2 TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '120 GB SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '256 GB SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '480 GB SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '512 GB SSD',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '512GB PCIe NVMe',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('storages')->insert([
            'size' => '32 GB',
            'type' => 'Micro SD',
            'created_at' => now(),
        ]);
    }
}