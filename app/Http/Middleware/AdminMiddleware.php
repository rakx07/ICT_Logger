<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and an admin
        if (Auth::check() && Auth::user()->admin == 1) {
            return $next($request);
        }

        // Redirect non-admin users
        return redirect()->route('tasks.index')->with('error', 'Access Denied: Admins only.');
    }
}
