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
                'name' => 'Игрушки',
                'slug' => 'igrushki',
                'page_title' => 'Игрушки',
                'position' => 1,
            ],
            [
                'parent_id' => 1,
                'name' => 'Машинки',
                'slug' => 'mashinki',
                'page_title' => 'Машинки',
                'position' => 2,
            ],
            [
                'parent_id' => 1,
                'name' => 'Мягкие игрушки',
                'slug' => 'myagkiye-igrushki',
                'page_title' => 'Мягкие игрушки',
                'position' => 3,
            ],
            [
                'parent_id' => 2,
                'name' => 'Обычные машинки',
                'slug' => 'obychnyye-mashinki',
                'page_title' => 'Обычные машинки',
                'position' => 4,
            ],
            [
                'parent_id' => 2,
                'name' => 'Машинки на пульте управления',
                'slug' => 'mashinki-na-pulte-upravleniya',
                'page_title' => 'Машинки на пульте управления',
                'position' => 5,
            ]
        ];

        foreach ($data as $key => $category) {
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
