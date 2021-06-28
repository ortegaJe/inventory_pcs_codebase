<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('SET IDENTITY_INSERT campus ON;');
        DB::table('campus')->insert([
            'id' => 1,
            'abreviature' => 'MAC',
            'name' => 'VIVA 1A IPS MACARENA',
            'slug' => 'viva-1a-macarena',
            'address' => null,
            'created_at' => NOW(),
            'updated_at' => null,
        ]);

        DB::table('campus')->insert([
            'id' => 2,
            'abreviature' => 'C30',
            'name' => 'VIVA 1A IPS CALLE 30',
            'slug' => 'viva-1a-calle-30',
            'address' => null,
            'created_at' => NOW(),
            'updated_at' => null,
        ]);

        DB::table('campus')->insert([
            'id' => 3,
            'abreviature' => 'C16',
            'name' => 'VIVA 1A IPS CARRERA 16',
            'slug' => 'viva-1a-carrera-16',
            'address' => null,
            'created_at' => NOW(),
            'updated_at' => null,
        ]);

        DB::table('campus')->insert([
            'id' => 4,
            'abreviature' => 'SOL',
            'name' => 'VIVA 1A IPS SOLEDAD',
            'slug' => 'viva-1a-soledad',
            'address' => null,
            'created_at' => NOW(),
            'updated_at' => null,
        ]);
        DB::unprepared('SET IDENTITY_INSERT campus OFF;');
    }
}
