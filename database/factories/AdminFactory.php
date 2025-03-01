<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'email' => fake()->email(),
            'password' => 'password',
            'name' => fake()->name(),
            'role' => fake()->randomElement(['1','2']),
        ];
    }

    public function specificAdmin()
    {
        return $this->state([
            'email' => 'admin@email.com',
            'role' => 1,
        ]);
    }
}
