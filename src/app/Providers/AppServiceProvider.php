<?php

namespace App\Providers;

use App\Models\AdminPanel\MenuLink;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
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
            $menuLinks = MenuLink::where('is_show', true)->get();
            $view->with('menuLinks', $menuLinks);
        });

        // Добавление остальные "get"-запросов при пагинации
        $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
            return $paginator->appends(Arr::except(request()->input(), $paginator->getPageName()));
        });
    }
}
