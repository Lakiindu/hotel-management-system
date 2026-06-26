<?php

// Import Laravel Application class
use Illuminate\Foundation\Application;

// Import Exception configuration class
use Illuminate\Foundation\Configuration\Exceptions;

// Import Middleware configuration class
use Illuminate\Foundation\Configuration\Middleware;

// Create and configure the Laravel application
return Application::configure(basePath: dirname(__DIR__))

    // Configure application routes
    ->withRouting(

        // Web routes file
        web: __DIR__.'/../routes/web.php',

        // Artisan console commands file
        commands: __DIR__.'/../routes/console.php',

        // Health check URL
        health: '/up',
    )

    // Register custom middleware and CSRF exceptions
    ->withMiddleware(function (Middleware $middleware) {

        // Create middleware alias named "admin"
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // Exclude PayHere notify URL from CSRF protection
        // PayHere sends POST request from outside your Laravel app
        $middleware->validateCsrfTokens(except: [
            'payhere/notify',
        ]);
    })

    // Configure exception handling
    ->withExceptions(function (Exceptions $exceptions): void {

        // Custom exception handling can be added here

    })

    // Create and start the application
    ->create();