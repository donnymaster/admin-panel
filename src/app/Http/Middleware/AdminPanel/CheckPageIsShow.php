<?php

namespace App\Http\Middleware\AdminPanel;

use Closure;
use Illuminate\Http\Request;
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
        // проверять доступность страницы в зависимости от того показывается она в меню или нет
        return $next($request);
    }
}
