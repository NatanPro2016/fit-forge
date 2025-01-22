<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrainerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated under the 'trainer' guard
        if (Auth::guard('tanner')->check()) {
            return $next($request); // Allow access
        }

        // Redirect unauthorized users to trainer login
        return redirect('/trainer/login')->with('error', 'Unauthorized access');
    }
}
