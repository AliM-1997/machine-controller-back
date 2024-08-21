<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'User not authenticated'
            ], 401);
        }

        // Check if the authenticated user has the 'admin' role
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'details' => 'User does not have the required role'
            ], 403);
        }
        
        return $next($request);
    }
}
