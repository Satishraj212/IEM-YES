<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'branch' => \App\Http\Middleware\EnsureHasBranch::class,
        ]);

        // Guests hitting the student dashboard belong on the chapter picker,
        // not the staff email/password login page.
        $middleware->redirectGuestsTo(fn (Request $request) =>
            $request->is('dashboard/student*') ? route('login.student') : route('login')
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
