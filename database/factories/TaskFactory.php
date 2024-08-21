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
            'jobDescription' => fake()->sentence(),
            'assignedDate' =>fake()->date(),
            'dueDate' => fake()->date(),
            'location' => fake()->address(),
            'status' => fake()->randomElement(['Completed', 'Risked', 'Delayed', 'In Progress', 'Pending']),
        ];
    }
}
