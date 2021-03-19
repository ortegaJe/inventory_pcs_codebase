<?php

namespace Database\Seeders;

use App\Models\Campus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         //\App\Models\User::factory(1)->create();
         $this->call([
            UsersSeeder::class,
            ProfilesSeeder::class,
            TypesSeeder::class,
            //Campus::class,
            //CampuUsersSeeder::class,
    ]);
    }
}
