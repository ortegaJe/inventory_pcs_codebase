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
         $this->call([
            UsersSeeder::class,
            ProfilesSeeder::class,
            TypesSeeder::class,
            RamSeeder::class,
            HddSeeder::class,
            BrandSeeder::class,
            OsSeeder::class
            //Campus::class,
            //CampuUsersSeeder::class,
    ]);
            //\App\Models\Computer::factory(100)->create();
    }
}
