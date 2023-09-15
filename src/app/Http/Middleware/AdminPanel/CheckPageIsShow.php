<?php

namespace App\Http\Middleware\AdminPanel;

use App\Models\AdminPanel\MenuLink;
use App\Services\AdminPanel\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPageIsShow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $currentRoute = Route::currentRouteName();
        $route = MenuLink::where('route', $currentRoute)->first();

        if(!$route) {
            return $next($request);
        }

        if(!$route->is_show) {
            return redirect(UserService::redirectToPanel());
        }

        return $next($request);
    }
}
