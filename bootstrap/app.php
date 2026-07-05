<?php

use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Добавляем CORS и сессии для API
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            EncryptCookies::class
        ]);

        // Настройка CORS через middleware
        $middleware->validateCsrfTokens(except: [
            'api/*' // Отключаем CSRF для API (если используете)
        ]);

        // Для продакшена - доверенные прокси
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })
    ->create();
