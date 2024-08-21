<?php

namespace Database\Factories;
use App\Models\MachineInput;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MachineInput>
 */
class MachineInputFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'machine_id'=>Machine::factory(),
            'operating_time'=>fake->randomfloat(2,0,1000),
            'down_time'=>fake->randomfloat(2,0,1000),
            'number_of_failure'=>fake->randomfloat(2,0,1000),
            'actual_output'=>fake->randomfloat(2,0,1000),
        ];
    }
}
