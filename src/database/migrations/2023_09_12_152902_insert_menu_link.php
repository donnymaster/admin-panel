<?php

use App\Models\AdminPanel\MenuLink;
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
        $links = [
            [
                'name' => 'Доска',
                'route' => 'admin.board',
                'is_show' => true,
            ],
            [
                'name' => 'Страницы',
                'route' => 'admin.pages',
                'is_show' => true,
            ],
            [
                'name' => 'Каталог',
                'route' => 'admin.catalogs',
                'is_show' => true,
            ],
            [
                'name' => 'Обмен данными',
                'route' => 'admin.data-exchange',
                'is_show' => true,
            ],
            [
                'name' => 'Настройки',
                'route' => 'admin.settings',
                'is_show' => true,
            ],
            [
                'name' => 'Заявки',
                'route' => 'admin.applications',
                'is_show' => true,
                'parent' => 1,
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
