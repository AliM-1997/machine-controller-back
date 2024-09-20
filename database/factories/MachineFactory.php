<?php

namespace Database\Factories;

use App\Models\SparePart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->word(),
            'serial_number' => 'SN' . fake()->unique()->numberBetween(1000, 9999),
            'status' => fake()->randomElement(['active', 'under maintenance', 'attention']),
            'location' => fake()->word(),
            'image_path' => 'path/to/image.jpg',
            'description' => fake()->text(),
            'last_maintenance'=>fake()->date(),
            'unit_per_hour' => fake()->numberBetween(1, 100), 
        ];
    }
}
