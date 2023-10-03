<?php

namespace App\Traits\Blade;

use Illuminate\Support\Facades\Blade;

trait CheckRoleUserTrait
{
    public function checkRoleDirective()
    {
        // проверка на админа
        Blade::directive('isAdmin', function () {
            return "<?php if(Auth::user()->isAdmin()): ?>";
        });
        Blade::directive('endIsAdmin', function () {
            return "<?php endif; ?>";
        });


        // проверка на супер админа
        Blade::directive('isSuperAdmin', function () {
            return "<?php if(Auth::user()->isSuperAdmin()): ?>";
        });
        Blade::directive('endIsSuperAdmin', function () {
            return "<?php endif; ?>";
        });

        // проверка на менеджера
        Blade::directive('isManager', function () {
            return "<?php if(Auth::user()->isSuperAdmin()): ?>";
        });
        Blade::directive('endIsManager', function () {
            return "<?php endif; ?>";
        });
    }
}
