<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CspMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' https://kit.fontawesome.com/ https://cdn.jsdelivr.net https://code.jquery.com https://cdn.datatables.net/ https://cdnjs.cloudflare.com/; style-src 'self' 'unsafe-inline'  https://fonts.googleapis.com/ https://cdn.datatables.net https://ka-f.fontawesome.com https://cdn.jsdelivr.net; img-src 'self' data:; font-src 'self' https://ka-f.fontawesome.com https://fonts.gstatic.com/; connect-src 'self' https://ka-f.fontawesome.com;";

        $response->header('Content-Security-Policy', $csp);
        return $response;
    }
}
