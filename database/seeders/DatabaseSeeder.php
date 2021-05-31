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
                        RoleSeeder::class,
                        UsersSeeder::class,
                        ProfilesSeeder::class,
                        ProfileUserSeeder::class,
                        TypesDevicesSeeder::class,
                        MemoryRamSeeder::class,
                        //SlotTwoRamSeeder::class,
                        StoragesSeeder::class,
                        //SecondStorages::class,
                        BrandSeeder::class,
                        OsSeeder::class,
                        ProcessorSeeder::class,
                        CampusSeeder::class,
                        CampuUsersSeeder::class,
                        StatusSeeder::class,
                        //StatuCodesSeeder::class,
                ]);
                //\App\Models\Computer::factory(100)->create();
        }
}
