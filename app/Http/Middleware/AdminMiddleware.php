<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    // Allow access only to authenticated administrators
    public function handle(Request $request, Closure $next): Response
    {
        // Check whether the user is logged in and has the admin role
        if (Auth::check() && Auth::user()->role === 'admin') {

            // Continue to the requested page
            return $next($request);
        }

        // Redirect unauthorized users to the customer dashboard
        return redirect()->route('customer.dashboard')
            ->with('error', 'Access Denied');
    }
}