<?php

namespace Database\Factories;

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
            'name' => fake()->unique()->word(),
            'serial_number' => fake()->unique()->word(),
            'status' => fake()->randomElement(['active', 'under maintenance', 'attention']),
            'location' => fake()->optional()->word(),
            'image_path' => fake()->optional()->imageUrl(),
            'description' => fake()->optional()->text(),
            'unit-per-hour' => fake()->numberBetween(1, 100),
        ];
    }
}
