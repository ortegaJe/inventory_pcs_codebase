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
            'ram' => 'NO APLICA',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '1GB DDR2 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '1GB DDR2 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '2GB DDR2 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '2GB DDR2 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '4GB DDR3 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '4GB DDR3 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '4GB DDR4 SO-DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '4GB DDR4 DIMM',
            'created_at' => now(),
        ]);

        DB::table('slot_one_rams')->insert([
            'ram' => '8GB DDR3 SO-DIMM',
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
