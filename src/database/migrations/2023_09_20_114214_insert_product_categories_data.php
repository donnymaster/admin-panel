<?php

use App\Models\AdminPanel\ProductCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            [
                'name' => 'Комплектующие',
                'slug' => 'komplektuyushie',
                'page_title' => 'Комплектующие',
                'position' => 1,
            ],
            [
                'parent_id' => 1,
                'name' => 'Процессоры',
                'slug' => 'processory',
                'page_title' => 'Процессоры',
                'position' => 1,
            ],
            [
                'parent_id' => 1,
                'name' => 'Видеокарты',
                'slug' => 'videokarty',
                'page_title' => 'Видеокарты',
                'position' => 2,
            ],

            [
                'name' => 'Телефоны',
                'slug' => 'telefony',
                'page_title' => 'Телефоны',
                'position' => 2,
            ],
            [
                'parent_id' => 4,
                'name' => 'Сенсорные',
                'slug' => 'sensornye',
                'page_title' => 'Сенсорные',
                'position' => 1,
            ],
            [
                'parent_id' => 4,
                'name' => 'Кнопочные',
                'slug' => 'knopochnye',
                'page_title' => 'Кнопочные',
                'position' => 2,
            ],
        ];

        foreach ($data as $category) {
            ProductCategory::create($category);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
