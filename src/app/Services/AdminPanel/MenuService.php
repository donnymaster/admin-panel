<?php

namespace App\Services\AdminPanel;

use App\Models\AdminPanel\MenuLink;

class MenuService
{
    public function checkVisibleByPageName($pageName)
    {
        $link = MenuLink::where('route', $pageName)->first();

        if (!$link) {
            return true;
        }

        return $link->is_show;
    }
}
