<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthenticateApi;
use App\Http\Middleware\SessionAuth;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
         $middleware->alias(aliases: [
            'apiauth' => AuthenticateApi::class,
             'sessionauth' => SessionAuth::class,
            'admin' => AdminMiddleware::class,
            'users' => UserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
