<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotOneRamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slot_one_rams')->insert([
            'size' => NULL,
            'storage_unit' => NULL,
            'type' => 'NO APLICA',
            'format' => NULL,
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 1,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 1,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 2,
            'storage_unit' => 'GB',
            'type' => 'DDR2',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 4,
            'storage_unit' => 'GB',
            'type' => 'DDR4',
            'format' => 'DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'size' => 8,
            'storage_unit' => 'GB',
            'type' => 'DDR3',
            'format' => 'SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '8GB DDR3 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '8GB DDR4 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '8GB DDR4 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '16GB DDR4 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '16GB DDR4 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '32GB DDR4 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '32GB DDR4 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '64GB DDR4 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '64GB DDR4 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '2GB DDR3 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '2GB DDR3 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '2GB LPDDR4',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => 'DISPONIBLE',
            'created_at' => now(),
        ]);
    }
}
