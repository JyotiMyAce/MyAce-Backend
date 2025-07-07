<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (!Auth::guard($guard)->check()) {
                if (!$request->expectsJson()) {
                    if ($request->is('admin') || $request->is('admin/*')) {
                        return redirect()->route('admin.login.form');
                    }

                    return redirect()->route('login');
                }
            }
        }

        return $next($request);
    }
}
