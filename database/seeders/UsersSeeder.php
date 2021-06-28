<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'cc' => rand(1, 111111111),
            'name' => 'Jefferson',
            'middle_name' => 'Javier',
            'last_name' => 'Ortega',
            'second_last_name' => 'Pacheco',
            'nick_name' => 'ADMIN',
            'birthday' => '1991/08/10',
            'sex' => 'M',
            'phone_number' => '3002777694',
            'optional_phone_number' => '3002777694',
            'avatar' => 'boss.svg',
            'email' => 'admin.inventor@viva1a.com.co',
            'password' => bcrypt('123.*'),
            'created_at' => now('America/Bogota')->toDateTimeString(),
            'is_active' => true
        ])->assignRole('super_admin');

        User::create([
            'cc' => '1143434718',
            'name' => 'Jefferson',
            'middle_name' => 'Javier',
            'last_name' => 'Ortega',
            'second_last_name' => 'Pacheco',
            'nick_name' => 'JORTEGA',
            'birthday' => '1991/08/10',
            'sex' => 'M',
            'phone_number' => '3002777694',
            'optional_phone_number' => '3002777694',
            'avatar' => 'boss.svg',
            'email' => 'jortega@viva1a.com.co',
            'password' => bcrypt('123.*'),
            'created_at' => now('America/Bogota')->toDateTimeString(),
            'is_active' => 1,
        ])->assignRole('tec_sedes');
    }
}
