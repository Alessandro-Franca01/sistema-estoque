<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Aliases de middleware da aplicação
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'set.current.department' => \App\Http\Middleware\SetCurrentDepartment::class,
        ]);

        // Middleware de tenant para todas as rotas web
        $middleware->appendToGroup('web', [
            'set.current.department',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
