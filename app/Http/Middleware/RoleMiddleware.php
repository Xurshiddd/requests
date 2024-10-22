<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (Auth::check() && Auth::user()->hasRole($roles)||$request->url() == 'http://127.0.0.1:8000/admin/requests' && $request->method() == 'POST' || $request->method() == 'DELETE') {
            return $next($request);
        }

        // Redirect or abort if user doesn't have the right role
        return redirect('/dashboard')->with('error', 'Unauthorized Access');
    }
}
