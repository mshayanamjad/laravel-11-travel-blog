<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\AdminRedirect::class,
            'admin.auth' => \App\Http\Middleware\AdminAuthenticate::class,

            'editor.guest' => \App\Http\Middleware\EditorRedirect::class,
            'editor.auth' => \App\Http\Middleware\EditorAuthenticate::class,
        ]);


        $middleware->redirectTo(
            guests: '/travel-blog/login',
            users: '/travel-blog/profile',
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
