<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventMultipleRoleLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::guard('admin')->check()) {
            return redirect()->intended('/admin/dashboard');
        } else if (Auth::guard('tanner')->check()) {
            return redirect()->intended('/trainer/dashboard');
        } else if (auth()->check()) {
            return redirect()->intended('/users/dashboard');
        }
        return $next($request);
    }
}
