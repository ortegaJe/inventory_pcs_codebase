<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatuCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('status_computers_codes')->insert([
            'statu_id' => 1,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 2,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 3,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 4,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 5,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 6,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 7,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 8,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 9,
            'created_at' => now(),
        ]);

        DB::table('status_computers_codes')->insert([
            'statu_id' => 10,
            'created_at' => now(),
        ]);
    }
}
