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
            ],
            [
                'parent_id' => 1,
                'name' => 'Машинки',
                'slug' => 'mashinki',
                'page_title' => 'Машинки',
            ],
            [
                'parent_id' => 1,
                'name' => 'Мягкие игрушки',
                'slug' => 'myagkiye-igrushki',
                'page_title' => 'Мягкие игрушки',
            ],
            [
                'parent_id' => 2,
                'name' => 'Обычные машинки',
                'slug' => 'obychnyye-mashinki',
                'page_title' => 'Обычные машинки',
            ],
            [
                'parent_id' => 2,
                'name' => 'Машинки на пульте управления',
                'slug' => 'mashinki-na-pulte-upravleniya',
                'page_title' => 'Машинки на пульте управления',
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
