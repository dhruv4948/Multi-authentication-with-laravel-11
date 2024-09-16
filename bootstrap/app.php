<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // $middleware->alias([
        //     'user-access'=> \App\Http\Middleware\UserAccess::class,
        // ]);

        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\AdminRedirect::class,
            'admin.auth' => \App\Http\Middleware\AdminAithenticate::class,
            'teamLeader.guest'=>\App\Http\Middleware\teamLeaderRedirect::class,
            'teamLeader.auth'=>\App\Http\Middleware\teamLeaderAuthenticate::class,
        ]);

        $middleware->redirectTo(
            guests: '/account/login',
            users: '/account/dashboard',
        );
    })
    ->withSchedule(function ( $schedule) {
        require __DIR__.'/../routes/console.php';
    })

    ->withExceptions(function (Exceptions $exceptions) {

    })->create();

