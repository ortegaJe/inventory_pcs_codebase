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
                'id'    => 'MAC',
                'description' => 'VIVA 1A IPS MACARENA',
                'created_at' => NOW(),
            ],
            [
                'id'    => 'C16',
                'description' => 'VIVA 1A IPS CARRERA 16',
                'created_at' => NOW(),
            ],
        ];

        Campu::insert($campus);
    }
}
