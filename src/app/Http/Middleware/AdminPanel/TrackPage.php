<?php

namespace App\Http\Middleware\AdminPanel;

use App\Models\AdminPanel\Page;
use App\Services\AdminPanel\PageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        $page = Page::where('route', $path)->first();

        if (!$page) {
            return $next($request);
        }

        if ($page->is_track) {
            PageService::takeSnapshotVisiter($path, $page->name);
        }

        return $next($request);
    }
}
