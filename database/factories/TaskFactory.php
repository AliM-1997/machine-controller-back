<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Machine;
use App\Models\SparePart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'machine_id' => Machine::factory(),
            'Spare_Part_id' => SparePart::factory(),
            'jobDescription' => $this->faker->sentence(),
            'assignedDate' => $this->faker->date(),
            'dueDate' => $this->faker->date(),
            'location' => $this->faker->address(),
        ];
    }
}
