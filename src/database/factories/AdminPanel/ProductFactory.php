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
            'page_title' => fake()->word(),
            'name_tile' => fake()->word(),
            'category_id' => fake()->randomElement([1, 2]),
            'vendor_code' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'slug' => fake()->word(),
        ];
    }
}
