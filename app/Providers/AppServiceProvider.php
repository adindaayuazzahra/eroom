<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCspHeader();
    }

    private function registerCspHeader()
    {
        $cspDirectives = [
            'default-src' => ["'none'",],
            'script-src' => ["'self'",            "'unsafe-inline'",            "'unsafe-eval'", 'https://cdn.datatables.net/'],
            'style-src' => ["'self'",            "'unsafe-inline'",],
            'img-src' => ["'self'",            'data:',],
            'font-src' => ["'self'",],
            'connect-src' => ["'self'",],
            'object-src' => ["'none'",],
            'frame-src' => ["'none'",],
            'media-src' => ["'self'",],
            'form-action' => ["'self'",],
            'frame-ancestors' => ["'none'",],
            'base-uri' => ["'self'",],
            'manifest-src' => ["'self'",],
        ];

        $cspHeader = collect($cspDirectives)
            ->map(function ($values, $directive) {
                return $directive . ' ' . implode(' ', $values);
            })
            ->implode('; ');

        Response::macro('csp', function (Response $response) use ($cspHeader) {
            $response->header('Content-Security-Policy', $cspHeader);

            return $response;
        });

        app('router')->pushMiddlewareToGroup('web', \App\Http\Middleware\CspMiddleware::class);
    }
}
