<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemoryRamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memory_rams')->insert([
            'size' => NULL,
            'storage_unit' => NULL,
            'type' => 'NO APLICA',
            'format' => NULL,
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'LPDDR4',
            'format' => NULL,
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 8,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 8,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 8,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 8,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 16,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 16,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 32,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => 32,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('memory_rams')->insert([
            'size' => NULL,
            'storage_unit' => NULL,
            'type' => 'NO DISPONIBLE',
            'format' => NULL,
            'created_at' => now(),
        ]);


        DB::table('memory_rams')->insert([
            'size' => NULL,
            'storage_unit' => NULL,
            'type' => 'DISPONIBLE',
            'format' => NULL,
            'created_at' => now(),
        ]);


        DB::table('memory_rams')->insert([
            'size' => 1,
            'storage_unit' => 'GB',
            'type' => 'LPDDR4',
            'format' => NULL,
            'created_at' => now(),
        ]);
    }
}
