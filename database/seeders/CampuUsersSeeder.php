<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampuUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campu_users')->insert([
            'user_id' => 1,
            'campu_id' => 'MAC',
            'is_principal' => false,
            'created_at' => now(),
        ]);

        DB::table('campu_users')->insert([
            'user_id' => 2,
            'campu_id' => 'MAC',
            'is_principal' => true,
            'created_at' => now(),
        ]);

        DB::table('campu_users')->insert([
            'user_id' => 2,
            'campu_id' => 'C16',
            'is_principal' => true,
            'created_at' => now(),
        ]);
    }
}
