<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\AdminPanel\Pages::factory(30)->create();
        \App\Models\AdminPanel\Application::factory(30)->create();
        \App\Models\AdminPanel\Statistic::factory(50)->create();
    }
}
