<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,   // Untuk memastikan user sudah login
            'role' => RoleMiddleware::class, // Untuk membatasi akses berdasarkan role
            'admin' => AdminMiddleware::class, // Untuk middleware admin
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
