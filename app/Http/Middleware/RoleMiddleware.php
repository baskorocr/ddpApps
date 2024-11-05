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
    public function handle(Request $request, Closure $next, $role): Response
    {

        if (!Auth::check()) {
            // Redirect to login page if not logged in
            return redirect()->route('login'); // Assuming 'login' is the name of your login route
        }

        $user = Auth::user();

        // Check the user's role
        if ($user->role == $role) {
            return $next($request);
        }

        // Redirect back if the user doesn't have the required role
        return redirect()->back();


        // Redirect if not authorized
    }
}