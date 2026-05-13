<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
<<<<<<< HEAD
=======
        $middleware->alias([
            'subscription' => \App\Http\Middleware\CheckSubscription::class,
        ]);
>>>>>>> 859410876d405b3bca05890f854eef0ee84a2e2e
        //
        // $middleware->validateCsrfTokens(except: [
        //     'stripe/*',
        //     'http://example.com/foo/bar',
        //     'http://example.com/foo/*',
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
