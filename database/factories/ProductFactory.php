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
        'name' => fake()->words(3, true), // Random 3-word name
        'description' => fake()->sentence(),
        'quantity' => fake()->numberBetween(1, 100),
        'unit_price' => fake()->randomFloat(2, 10, 500), // Price between 10 and 500
        'amount_sold' => fake()->randomFloat(2, 0, 500),
        // We don't set user_id here; we will set it in the Seeder
    ];
}
}
