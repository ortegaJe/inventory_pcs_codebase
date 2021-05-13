<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                        SlotOneRamSeeder::class,
                        SlotTwoRamSeeder::class,
                        StorageSeeder::class,
                        BrandSeeder::class,
                        OsSeeder::class,
                        CampusSeeder::class,
                        CampuUsersSeeder::class,
                        //StatusSeeder::class,
                        //StatuCodesSeeder::class,
                ]);
                //\App\Models\Computer::factory(100)->create();
        }
}
