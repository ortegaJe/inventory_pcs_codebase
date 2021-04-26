<?php

namespace Database\Factories;

use App\Helpers\Generator;
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

        $str = $this->faker->ean8;
        //$str = rand(1,9999);
        $inv_code_chain = 'PC' . $str;

        $str = Str::random(5);
        $pc_name_chain = 'V1AMAC-' . $str;

        return [
            'batch' => 'INVPC71MAC',
            'inv_code' => $inv_code_chain,
            'brand_id' => 3,
            'model' => 'M710Q DESKTOP (THINKCENTRE) - TYPE 10MR',
            'serial' => Str::random(10),
            'serial_monitor' => Str::random(10),
            'type_id' => 1,
            'slot_one_ram_id' => rand(5, 12),
            'slot_two_ram_id' => rand(5, 12),
            'hdd_id' => 23,
            'campu_id' => 'MAC',
            'cpu' => 'INTEL(R) CORE(TM) I5-7400T CPU @ 2.40GHZ',
            'ip' => $this->faker->ipv4,
            'mac' => $this->faker->macAddress,
            'os_id' => 1,
            'anydesk' => Str::random(9),
            'pc_name' => $pc_name_chain,
            'image' => $this->faker->imageUrl(),
            'location' => $this->faker->name,
            'observation' => $this->faker->text,
            'rowguid' => $this->faker->uuid,
            'created_at' => now(),
            'updated_at' => null,
            'deleted_at' => null,
            'deleted_at_status' => null,
            'statu_id' => rand(1, 5)
        ];
    }

    public function array($max)
    {
        $values = [];
        
        for ($i=1; $i < $max; $i++) { 
            $values[] = $i;
        }

        return $values;
    }
}
