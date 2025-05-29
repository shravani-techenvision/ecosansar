<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    // Define allowed roles
    $allowedRoles = ['superadmin', 'admin'];

    // Check if the user is authenticated and their role is allowed
    if (Auth::check() && in_array(Auth::user()->type, $allowedRoles)) {
        return $next($request); // Grant access
    }

    // Redirect to unauthorized route or abort with 403
    return redirect()->route('admin_login');
}
}