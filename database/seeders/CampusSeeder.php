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
        DB::table('campus')->insert([
            'id' => 'V1AMAC',
            'description' => 'VIVA 1A IPS MACARENA',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1AC30',
            'description' => 'VIVA 1A IPS CALLE 30',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1AC16',
            'description' => 'VIVA 1A IPS CARRERA 16',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1ASOL',
            'description' => 'VIVA 1A IPS SOLEDAD',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1ASSJ',
            'description' => 'VIVA 1A IPS SURA SAN JOSE',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1AMTZ',
            'description' => 'VIVA 1A CASA MATRIZ',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1ACTI',
            'description' => 'VIVA 1A IPS CALL CENTER',
            'created_at' => NOW(),
        ]);

        DB::table('campus')->insert([
            'id' => 'V1ACNT',
            'description' => 'VIVA 1A IPS COUNTRY',
            'created_at' => NOW(),
        ]);
    }
}
