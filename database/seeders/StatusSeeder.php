<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('status_computers')->truncate();

        DB::table('status')->insert([
            'name' => 'rendimiento optimo',
            'created_at' => now(),
        ]);

        DB::table('status')->insert([
            'name' => 'rendimiento bajo',
            'created_at' => now(),
        ]);

        DB::table('status')->insert([
            'name' => 'hurtado',
            'created_at' => now(),
        ]);

        DB::table('status')->insert([
            'name' => 'eliminado',
            'created_at' => now(),
        ]);

        DB::table('status')->insert([
            'name' => 'dado de baja',
            'created_at' => now(),
        ]);
    }
}
