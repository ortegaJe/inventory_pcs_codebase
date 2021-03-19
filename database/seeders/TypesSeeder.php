<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name' => 'PC',
            'created_at' => now(),
        ]);

        DB::table('types')->insert([
            'name' => 'ALL IN ONE',
            'created_at' => now(),
        ]);
    }
}
