<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'total' => fake()->numberBetween(1000,2000),
            // 'user_id' => fake()->numberBetween(1,10),
            // 'payment_id' => fake()->numberBetween(1,10),
        ];
    }
}
