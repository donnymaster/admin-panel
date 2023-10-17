<?php

namespace Database\Factories\AdminPanel;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminPanel\Review>
 */
class ReviewFactory extends Factory
{
    static $position = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'position' => self::$position++,
            'is_show' => true,
            'comment' => fake()->word(),
            'rating' => fake()->randomElement([1, 2, 3, 4, 5]),
            'created_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }
}
