<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access this page.');
        }

        if (!Auth::user()->is_admin) {
            return redirect('/dashboard')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
