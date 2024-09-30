<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            is_null(session('jwt_token')) ||
            is_null(session('jwt_exp')) ||
            session('jwt_exp') < now()->getTimestamp()
        ) {
            return $next($request);
        }

        return redirect('/dashboard');
    }
}
