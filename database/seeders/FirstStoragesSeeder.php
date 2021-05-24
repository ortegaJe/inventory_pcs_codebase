<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirstStoragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('first_storages')->insert([
            'size' => null,
            'storage_unit' => 'NO APLICA',
            'type' => null,
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '70',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '70',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '100',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '100',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '120',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '120',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '150',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '150',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '200',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '200',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '250',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '250',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '300',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '300',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '500',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '500',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '800',
            'storage_unit' => 'GB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '800',
            'storage_unit' => 'GB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '1',
            'storage_unit' => 'TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '1',
            'storage_unit' => 'TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '2',
            'storage_unit' => 'TB',
            'type' => 'Escritorio',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '2',
            'storage_unit' => 'TB',
            'type' => 'Portatil',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '120',
            'storage_unit' => 'GB',
            'type' => 'SSD',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '256',
            'storage_unit' => 'GB',
            'type' => 'SSD',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '480',
            'storage_unit' => 'GB',
            'type' => 'SSD',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '512',
            'storage_unit' => 'GB',
            'type' => 'SSD',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '512',
            'storage_unit' => 'GB',
            'type' => 'PCIe NVMe',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => '32',
            'storage_unit' => 'GB',
            'type' => 'Micro SD',
            'created_at' => now(),
        ]);

        DB::table('first_storages')->insert([
            'size' => null,
            'storage_unit' => 'DISPONIBLE',
            'type' => null,
            'created_at' => now(),
        ]);
    }
}
