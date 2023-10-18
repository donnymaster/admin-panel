<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable((function (NotFoundHttpException $e, Request $request) {
            $path = explode('/', $request->path());

            $type = isset($path[0]) ? $path[0] : '';

            if ($type != 'admin') {
                return response()->view('site-pages.errors.404', [], 404);
            }

            return response()->view('admin-panel.errors.404', [], 404);
        }));
    }
}
