<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(2),
            'stock' => fake()->numberBetween(1000, 10000),
            'price' => fake()->numberBetween(60000, 100000),
            'image_path' => fake()->url(),
        ];
    }
}
