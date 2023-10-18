<?php

namespace Database\Factories\AdminPanel;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->lexify('?????'),
            'route' => fake()->lexify('?????????'),
            'title' => fake()->word(),
            'description' => fake()->sentence(10),
            'keywords' => fake()->sentence(10),
        ];
    }
}
