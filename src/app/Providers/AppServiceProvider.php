<?php

namespace App\Providers;

use App\Models\AdminPanel\MenuLink;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $menuLinks = MenuLink::where('is_show', true)->whereNull('parent')->get();
            $view->with('menuLinks', $menuLinks);
        });

        // Добавление остальные "get"-запросов при пагинации
        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(Arr::except(request()->input(), $paginator->getPageName()));
        });

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
