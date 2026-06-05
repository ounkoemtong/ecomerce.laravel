<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
            'category_id' => rand(1,2),

            'brand_id' => rand(1,2),

            'name' => fake()->words(3, true),

            'slug' => fake()->slug(),

            'description' => fake()->paragraph(),

            'price' => fake()->numberBetween(10, 500),

            'discount_price' => fake()->numberBetween(5, 300),

            'stock_qty' => fake()->numberBetween(1, 100),

            'sku' => fake()->unique()->bothify('SKU-####'),

            'image' => fake()->imageUrl(),

            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
