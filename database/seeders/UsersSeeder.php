<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'cc' => '1143434718',
            'name' => 'Jefferson Javier',
            'last_name' => 'Ortega Pacheco',
            'nick_name' => 'JORTEGA',
            'age' => '19910810',
            'phone' => '3002777694',
            'avatar' => 'boss.svg',
            'email' => 'jortega@viva1a.com.co',
            'email_verified_at' => now(),
            'password' => bcrypt('123.*'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'is_active' => 1,
        ]);
    }
}
