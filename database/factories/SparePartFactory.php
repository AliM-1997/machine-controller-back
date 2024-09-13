<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SparePart>
 */
class SparePartFactory extends Factory
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
            'serial_number' => 'SN' . fake()->unique()->numberBetween(1000, 9999),
            'quantity' => fake()->numberBetween(0, 100),
            'description' => fake()->optional()->text(),
            'image_path' => 'path/to/image.jpg',
            'type'=>fake()->randomElement(['Mechanical', 'Electrical', 'Oil']),
            'standard_pressure' => $this->faker->randomFloat(2, 1, 100), 
            'life_cycle' => fake()->numberBetween(0, 1000),
        ];
    }
}
