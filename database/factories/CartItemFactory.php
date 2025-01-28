<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'shopping_session_id' => 1,
            // 'product_id' => $this->faker->numberBetween(2,10),
            // 'quantity' => $this->faker->numberBetween(2,20),
        ];
    }
}
