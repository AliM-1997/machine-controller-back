<?php

namespace Database\Factories;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MachineStatistic>
 */
class MachineStatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'machine_id' =>Machine::factory(),
            'operational_hours' => fake()->randomFloat(2, 0, 10000),
            'MTTR' => fake()->randomFloat(2, 0, 100),
            'MTTD' => fake()->randomFloat(2, 0, 100),
            'MTBF' => fake()->randomFloat(2, 0, 10000),
            'upTime' => fake()->randomFloat(2, 0, 100),
            'downTime' => fake()->randomFloat(2, 0, 100),
            'efficiency' => fake()->randomFloat(2, 0, 100),
            'availability' => fake()->randomFloat(2, 0, 100),
            'date' => fake()->date(),
        ];
    }
}
