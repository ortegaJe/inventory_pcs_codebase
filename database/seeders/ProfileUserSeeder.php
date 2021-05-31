<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_profiles')->insert([
            'profile_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'profile_id' => 2,
            'user_id' => 2,
            'created_at' => now(),
        ]);
    }
}
