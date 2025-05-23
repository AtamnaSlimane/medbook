<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use function Laravel\Prompts\warning;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )
       //
->withMiddleware(function (Middleware $middleware) {
    // Register your middleware aliases
    $middleware->alias([
        'role' => App\Http\Middleware\CheckRole::class,
        'auth' =>\Illuminate\Auth\Middleware\Authenticate::class,
    ]);

    // Configure middleware groups
    $middleware->group('web', [
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
