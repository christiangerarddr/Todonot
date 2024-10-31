<?php

namespace Database\Factories;

use App\Models\Todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'description' => fake()->sentence(10),
            'status' => fake()->randomElement([0, 1]),
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
