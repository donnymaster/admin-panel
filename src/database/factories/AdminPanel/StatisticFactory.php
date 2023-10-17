<?php

namespace Database\Factories\AdminPanel;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdminPanel\Statistic>
 */
class StatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ip_visitor' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'country_visitor' => fake()->country(),
            'device_visitor' => fake()->randomElement(['desktop', 'phone']),
            'os_visitor' => fake()->randomElement(['Windows', 'Android']),
            'os_version_visitor' => fake()->randomElement(['10', '11', '9', '7']),
            'browser_visitor' => fake()->randomElement(['Chrome', 'Mozilla', 'Opera', 'Yandex']),
            'browser_version_visitor' => fake()->randomElement(['117.0.0.0', '104.0.0.0', '100.0.0.0', '101.0.0.0']),
            'city_visitor' => fake()->city(),
            'page_name_visit' => fake()->randomElement(['Главная', 'О нас', 'Товары', 'Примеры работ']),
            'page_url_visit' => fake()->randomElement(['/', '/about', '/products', '/works']),
            'created_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }
}
