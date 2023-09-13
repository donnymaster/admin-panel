<?php

namespace App\Services\AdminPanel;

class UserService
{
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';

    public static function redirectToPanel() : string
    {
        return route('admin.board');
    }

    public static function redirectToLoginPage() : string
    {
        return route('get.login');
    }
}
