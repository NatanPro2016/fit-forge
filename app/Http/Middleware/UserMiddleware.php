<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated under the 'trainer' guard
        if (auth()->check()) {
            return $next($request); // Allow access
        }

        // Redirect unauthorized users to trainer login
        return redirect('/users/login')->with('error', 'Unauthorized access');
    }
}
