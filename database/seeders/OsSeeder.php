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
            'icon_os' => 'windows7.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X86',
            'version' => '7 PROFFESIONAL',
            'icon_os' => 'windows7.svg',
            'created_at' => now(),
        ]);


        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '8.1 PROFFESIONAL',
            'icon_os' => 'microsoft-windows.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X86',
            'version' => '8.1 PROFFESIONAL',
            'icon_os' => 'microsoft-windows.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X64',
            'version' => '10 PROFFESIONAL',
            'icon_os' => 'microsoft-windows.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'WINDOWS',
            'architecture' => 'X86',
            'version' => '10 PROFFESIONAL',
            'icon_os' => 'microsoft-windows.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'RASPBIAN GNU/LINUX',
            'architecture' => 'X86',
            'version' => '8.0 (jessie)',
            'icon_os' => 'raspberry-pi.svg',
            'created_at' => now(),
        ]);

        DB::table('operating_systems')->insert([
            'name' => 'RASPBIAN GNU/LINUX',
            'architecture' => 'X86',
            'version' => '9.4 (strech)',
            'icon_os' => 'raspberry-pi.svg',
            'created_at' => now(),
        ]);
    }
}
