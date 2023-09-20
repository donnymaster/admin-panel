<?php

namespace Database\Factories\AdminPanel;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminPanel\Product>
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
            'name' => fake()->word(),
            'category_id' => fake()->randomElement([1, 2]),
            'slug' => fake()->word(),
            'page_title' => fake()->word(),
            'name_tile' => fake()->word(),
            'price' => fake()->randomElement([20, 30, 40, 15, 19, 27]),
            'count' => fake()->randomElement([10, 100, 1000, 200, 400, 5]),
        ];
    }
}
