<?php

namespace App\Traits\Blade;

use App\Models\AdminPanel\MenuLink;

trait MenuLinkTrait
{
    public function addMenuLinks()
    {
        view()->composer('*', function ($view) {
            $menuLinks = MenuLink::where([['is_show', true], ['is_main_menu_link', true]])->whereNull('parent')->get();
            $view->with('menuLinks', $menuLinks);
        });
    }
}
