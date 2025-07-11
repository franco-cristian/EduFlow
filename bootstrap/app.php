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
    ->withMiddleware(function (Middleware $middleware) {
        
        // El middleware CSRF es parte del grupo 'web' por defecto.
        // A veces, al editar, se puede eliminar por error.
        // Laravel 12 lo añade automáticamente, pero si lo modificaste, 
        // asegúrate de que no has eliminado esta línea o su equivalente:
        $middleware->web(append: [
            // Middlewares adicionales para el grupo web si los necesitas.
        ]);

        // La configuración de la API que añadimos
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();