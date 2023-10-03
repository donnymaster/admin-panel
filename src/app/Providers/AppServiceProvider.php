<?php

namespace App\Providers;

use App\Traits\Blade\CheckRoleUserTrait;
use App\Traits\Blade\DirectiveVisibleByPageTrait;
use App\Traits\Blade\MenuLinkTrait;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use CheckRoleUserTrait, MenuLinkTrait, DirectiveVisibleByPageTrait;
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
        $this->directiveCheckVisibleByPageName();

        $this->addMenuLinks();

        $this->checkRoleDirective();
    }
}
