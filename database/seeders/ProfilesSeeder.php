<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            'name' => 'administrador',
            'created_at' => now(),
        ]);

        DB::table('profiles')->insert([
            'name' => 'soporte ti',
            'created_at' => now(),
        ]);
    }
}
