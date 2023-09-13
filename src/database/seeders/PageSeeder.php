<?php

namespace Database\Seeders;

use App\Models\AdminPanel\Pages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pages::factory(20)->create();
    }
}
