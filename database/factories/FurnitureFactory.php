<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FurnitureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'image' => $this->faker->word().'.jpg',
            'code' => $this->faker->bothify('?#?##?'),
            'description' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['Indoor','Outdoor','Handicraft','Root']),
            'wood_type' => $this->faker->randomElement(['Teak wood','Tiger wood','Mahogany wood','Root']),
            'width' => $this->faker->randomNumber(3,true),
            'length' => $this->faker->randomNumber(3,true),
            'height' => $this->faker->randomNumber(3,true),
            'stock' => $this->faker->randomNumber(2,true),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(3,true),
            //
        ];
    }
}
