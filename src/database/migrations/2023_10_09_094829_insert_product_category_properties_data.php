<?php

use App\Models\AdminPanel\ProductCategoryProperty;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $data = [
            /**
             * Для категории процессоров
             */
            [
                'name' => 'Количество ядер',
                'description' => 'Количество ядер',
                'slug' => 'kolichestvo-yader',
                'product_category_id' => 2,
            ],
            [
                'name' => 'Частота (Ггц)',
                'description' => 'Частота (Ггц)',
                'slug' => 'chastota',
                'product_category_id' => 2,
            ],
            [
                'name' => 'Тип поставки',
                'description' => 'Тип поставки',
                'slug' => 'tip-postavki',
                'product_category_id' => 2,
            ],
            /**
             * Для категории видеокарты
             */
            [
                'name' => 'Интерфейс подключения',
                'description' => 'Интерфейс подключения',
                'slug' => 'connection-interface',
                'product_category_id' => 3,
            ],
            [
                'name' => 'Объем видеопамяти',
                'description' => 'Объем видеопамяти',
                'slug' => 'obem-videopamyati',
                'product_category_id' => 3,
            ],
            [
                'name' => 'Тип видеопамяти',
                'description' => 'Тип видеопамяти',
                'slug' => 'tip-videopamyati',
                'product_category_id' => 3,
            ],
            /**
             * Для категории сенсорные
             */
            [
                'name' => 'Количество касаний',
                'description' => 'Количество касаний',
                'slug' => 'kolichestvo-kasanij',
                'product_category_id' => 5,
            ],
            [
                'name' => 'Размер экрана',
                'description' => 'Размер экрана',
                'slug' => 'razmer-ekrana',
                'product_category_id' => 5,
            ],
            [
                'name' => 'Объем аккумулятора',
                'description' => 'Объем аккумулятора',
                'slug' => 'obem-akkumulyatora',
                'product_category_id' => 5,
            ],
             /**
             * Для категории кнопочные
             */
            [
                'name' => 'Вес телефона',
                'description' => 'Вес телефона',
                'slug' => 'ves-telefona',
                'product_category_id' => 6,
            ],
            [
                'name' => 'Автономность',
                'description' => 'Автономность',
                'slug' => 'avtonomnost',
                'product_category_id' => 6,
            ],
            [
                'name' => 'Тип корпуса',
                'description' => 'Тип корпуса',
                'slug' => 'type-shell',
                'product_category_id' => 6,
            ],
        ];

        // foreach($data as $value) {
        //     ProductCategoryProperty::create($value);
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
