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
        static $firstCategory = 1;
        static $secondCategory = 1;
        $position = 0;

        $categoryId = fake()->randomElement([1, 2]);

        if ($categoryId === 1) {
            $position = $firstCategory;
            ++$firstCategory;
        }

        if ($categoryId === 2) {
            $position = $secondCategory;
            ++$secondCategory;
        }

        return [
            'name' => fake()->word(),
            'page_title' => fake()->word(),
            'name_tile' => fake()->word(),
            'visible' => true,
            'position_in_category' => $position,
            'category_id' => $categoryId,
            'vendor_code' => fake()->regexify('[A-Z]{5}[0-4]{3}'),
            'slug' => fake()->word(),
        ];
    }
}
