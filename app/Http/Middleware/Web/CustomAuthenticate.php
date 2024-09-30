<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('jwt_token') && session('jwt_exp')) {
            if (session('jwt_exp') > now()->getTimestamp()) {
                return $next($request);
            }

            $request->session()->invalidate();
        }

        return redirect('/auth/login');
    }
}
