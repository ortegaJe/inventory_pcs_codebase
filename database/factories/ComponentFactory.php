<?php

namespace Database\Factories;

use App\Models\Component;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComponentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Component::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //\App\Models\Component::factory(100)->create();

        $str = $this->faker->ean8();
        //$str = rand(1,9999);
        $inv_code_chain = 'PC' . $str;

        $str = Str::random(5);
        $pc_name_chain = 'V1AMAC-' . $str;

        /*for ($i = 1; $i <= 100; $i++) {
            return $i;
        }*/

        return [
            'device_id' => rand(1, 50),
            'monitor_serial_number' => Str::random(10),
            'slot_one_ram_id' => 14,
            'slot_two_ram_id' => 1,
            'first_storage_id' => 23,
            'second_storage_id' => 30,
            'processor_id' => rand(1, 20),
            'os_id' => rand(1, 8),
        ];
    }
}
