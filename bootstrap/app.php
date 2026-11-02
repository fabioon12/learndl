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
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->redirectTo(
            guests: '/login', 
            users: function (Request $request) { 
                $user = $request->user();

                if ($user->role === 'admin') {
                    return route('admin.dashboard');
                }

                if ($user->role === 'guru') {
                    return route('guru.dashboard');
                }

                return route('siswa.dashboard');
            }
        );

    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
