<?php

use App\Http\Middleware\Api\CustomEnsureEmailVerified as ApiCustomEnsureEmailVerified;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Web\CustomAuthenticate;
use App\Http\Middleware\Web\CustomEnsureEmailVerified;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Web\CustomRedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web/web.php',
        api: __DIR__ . '/../routes/api/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/auth')
                ->group(base_path('routes/api/auth.php'));

            Route::middleware('web')
                ->prefix('auth')
                ->group(base_path('routes/web/auth.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'custom-auth' => CustomAuthenticate::class,
            'custom-guest' => CustomRedirectIfAuthenticated::class,
            'custom-verified' => CustomEnsureEmailVerified::class,
            'api-custom-verified' => ApiCustomEnsureEmailVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found.'
                ], 404);
            }
        });

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*') && env('APP_DEBUG') === false) {
                return response()->json([
                    'message' => 'Method not allowed.'
                ]);
            }
        });
    })->create();
