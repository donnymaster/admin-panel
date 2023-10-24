<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\AdminPanel\Page::factory(30)->create();
        \App\Models\AdminPanel\Application::factory(30)->create();
        \App\Models\AdminPanel\Statistic::factory(50)->create();
        // \App\Models\AdminPanel\SiteSetting::factory(50)->create();
        // \App\Models\AdminPanel\Product::factory(50)->has(ProductVariant::factory()->count(2), 'variants')->create();
        \App\Models\AdminPanel\Review::factory(20)->create();
    }
}
