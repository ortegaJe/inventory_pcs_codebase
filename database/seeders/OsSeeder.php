<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '7 PROFFESIONAL',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '7 PROFFESIONAL',
            'created_at' => now(),
        ]);

        
        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '8.1 PROFFESIONAL',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '8.1 PROFFESIONAL',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '10 PROFFESIONAL',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X86',
            'version' => '10 PROFFESIONAL',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'RASPBERRY PI OS',
            'architecture' => 'X86',
            'version' => 'March 4th 2021',
            'created_at' => now(),
        ]);
    }
}
