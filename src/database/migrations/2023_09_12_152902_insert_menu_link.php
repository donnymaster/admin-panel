<?php

use App\Models\AdminPanel\MenuLink;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $links = [

            /**
             * Страница "Доска" и вложенные в нее страницы
             */
            [
                'name' => 'Доска',
                'route' => 'admin.board',
                'is_show' => true,
                'is_main_menu_link' => true,
            ],
            [
                'name' => 'Заявки',
                'route' => 'admin.applications',
                'is_show' => true,
            ],
            [
                'name' => 'Заказы',
                'route' => 'admin.orders',
                'is_show' => true,
            ],
            [
                'name' => 'Отзывы',
                'route' => 'admin.reviews',
                'is_show' => true,
            ],
            /**
             * ---------------------
             */


            /**
             * Страница "Страницы"
             */
            [
                'name' => 'Страницы',
                'route' => 'admin.pages',
                'is_show' => true,
                'is_main_menu_link' => true,
            ],
            /**
             * ---------------------
             */


            /**
             * Страница "Каталог"
             */
            [
                'name' => 'Каталог',
                'route' => 'admin.catalogs',
                'is_show' => true,
                'is_main_menu_link' => true,
            ],
            [
                'name' => 'Товары',
                'route' => 'admin.products',
                'is_show' => true,
            ],
            [
                'name' => 'Промокоды',
                'route' => 'admin.promocode',
                'is_show' => true,
            ],
            /**
             * ---------------------
             */


            /**
             * Страница "Обмен данными"
             */
            [
                'name' => 'Обмен данными',
                'route' => 'admin.data-exchange',
                'is_show' => true,
                'is_main_menu_link' => true,
            ],
            /**
             * ---------------------
             */


            /**
             * Страница "Настройки"
             */
            [
                'name' => 'Настройки',
                'route' => 'admin.settings',
                'is_show' => true,
                'is_main_menu_link' => true,
            ],
            /**
             * ---------------------
             */


            /**
             * Страница "Аккаунт"
             */
            [
                'name' => 'Аккаунт',
                'route' => 'admin.account',
                'is_show' => true,
            ],
            /**
             * ---------------------
             */

            /**
             * Страница "Пользователи"
             */
            [
                'name' => 'Пользователи',
                'route' => 'admin.users',
                'is_show' => true,
            ],
        ];

        foreach ($links as $key => $link) {
            MenuLink::create($link);
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
