<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ComputersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('computers')->insert([
            /*'lote' = 
            'inv_code'
            'brand'
            'model'
            'serial'
            'serial_monitor'
            'type_id'
            'ram_slot_0_id'
            'ram_slot_1_id'
            'hdd_id'
            'campus_id'
            'cpu'
            'ip'
            'mac'
            'os'
            'anydesk'
            'pc_name'
            'image'
            'location'
            'observation'
            'created_at'
            'updated_at'
            'deleted_at'
            'deleted_at_status'
            'status_id'*/
        ]);
    }
}
