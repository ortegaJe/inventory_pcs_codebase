<?php

namespace Database\Seeders;

use App\Models\Campu;
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
        $campus = [
            [
                'id' => 'MAC',
                'description' => 'VIVA 1A IPS MACARENA',
                'created_at' => NOW(),
            ],

            [
                'id' => 'C30',
                'description' => 'VIVA 1A IPS CALLE 30',
                'created_at' => NOW(),
            ],

            [
                'id' => 'C16',
                'description' => 'VIVA 1A IPS CARRERA 16',
                'created_at' => NOW(),
            ],

            [
                'id' => 'SOL',
                'description' => 'VIVA 1A IPS SOLEDAD',
                'created_at' => NOW(),
            ],

            [
                'id' => 'SSJ',
                'description' => 'VIVA 1A IPS SURA SAN JOSE',
                'created_at' => NOW(),
            ],

            [
                'id' => 'MTZ',
                'description' => 'VIVA 1A CASA MATRIZ',
                'created_at' => NOW(),
            ],

            [
                'id' => 'CTI',
                'description' => 'VIVA 1A IPS CALL CENTER',
                'created_at' => NOW(),
            ],

            [
                'id' => 'CNT',
                'description' => 'VIVA 1A IPS COUNTRY',
                'created_at' => NOW(),
            ],
        ];

        Campu::insert($campus);
    }
}
