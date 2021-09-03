<?php

namespace Database\Factories;

use App\Models\Computer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComputerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Computer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //\App\Models\Computer::factory(100)->create();

        $str = $this->faker->ean8();
        //$str = rand(1,9999);
        $inv_code_chain = 'PC' . $str;

        $str = Str::random(5);
        $pc_name_chain = 'V1AMAC-' . $str;

        return [
            'batch' => null,
            //'inventory_code_number' => $inv_code_chain,
            //'inventory_active_code' => rand(10000000, 900000000),
            //'brand_id' => rand(1, 5),
            //'model' => 'EQUIPO-' . Str::random(10),
            //'serial_number' => Str::random(10),
            'monitor_serial_number' => Str::random(10),
            //'type_device_id' => rand(1, 5),
            'slot_one_ram_id' => 14,
            'slot_two_ram_id' => 1,
            'first_storage_id' => 23,
            'second_storage_id' => 30,
            //'campu_id' => rand(1, 4),
            'processor_id' => rand(1, 20),
            //'ip' => $this->faker->ipv4(),
            //'mac' => $this->faker->macAddress(),
            'os_id' => rand(1, 8),
            'anydesk' => rand(1, 302) . ' ' . rand(1, 485) . ' ' . rand(1, 801),
            'pc_name' => $pc_name_chain,
            //'statu_id' => rand(1, 10),
            //'location' => $this->faker->name(),
            //'observation' => $this->faker->text(),
            'rowguid' => $this->faker->uuid(),
            //'created_at' => now('America/Bogota'),
            //'updated_at' => null,
            //'deleted_at' => null,
            //'is_active' => true,
        ];
    }
}
