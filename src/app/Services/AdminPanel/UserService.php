<?php

namespace App\Services\AdminPanel;

class UserService
{

    public static function redirectTo() : string
    {
        return route('admin.page.statistics');
    }
}
