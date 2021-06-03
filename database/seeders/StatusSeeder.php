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
            'name' => 'rendimiento óptimo',

        ]);

        DB::table('status')->insert([
            'name' => 'rendimiento bajo',

        ]);

        DB::table('status')->insert([
            'name' => 'hurtado',

        ]);

        DB::table('status')->insert([
            'name' => 'eliminado',

        ]);

        DB::table('status')->insert([
            'name' => 'dado de baja',

        ]);

        DB::table('status')->insert([
            'name' => 'averiado',

        ]);

        DB::table('status')->insert([
            'name' => 'retirado',

        ]);

        DB::table('status')->insert([
            'name' => 'reparado',

        ]);

        DB::table('status')->insert([
            'name' => 'asignación',

        ]);

        DB::table('status')->insert([
            'name' => 'reasignacíon',

        ]);
    }
}
