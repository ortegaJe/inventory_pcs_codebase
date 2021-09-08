<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //\App\Models\Device::factory(100)->create();

        $str = $this->faker->ean8();
        //$str = rand(1,9999);
        $inv_code_chain = 'PC' . $str;

        $str = Str::random(5);
        $pc_name_chain = 'V1AMAC-' . $str;

        /*for ($i = 1; $i <= 100; $i++) {
        }*/

        return [
            'batch' => null,
            'inventory_code_number' => $inv_code_chain,
            'fixed_asset_number' => rand(10000000, 900000000),
            'type_device_id' => 1,
            'brand_id' => rand(1, 5),
            'model' => 'EQUIPO-' . Str::random(10),
            'serial_number' => Str::random(10),
            'campu_id' => rand(1, 4),
            'ip' => $this->faker->ipv4(),
            'mac' => $this->faker->macAddress(),
            'statu_id' => rand(1, 10),
            'location' => $this->faker->name(),
            'custodian_assignment_date' => now(),
            'custodian_name' => $this->faker->name(),
            'assignment_statu_id' => 1,
            'observation' => $this->faker->text(),
            'rowguid' => $this->faker->uuid(),
            'created_at' => now('America/Bogota'),
            'updated_at' => null,
            'deleted_at' => null,
            'is_active' => true,
        ];
    }
}
