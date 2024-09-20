<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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
                "message" => "unauthorized",
                "details" => "User not authenticated"
            ], 401);
        }

        if ($user->role !== "user" && $user->role !== "admin") {
            return response()->json([
                "message" => "unauthorized",
                "details" => "User does not have the required role"
            ], 403);
        }

        return $next($request);
    }
}
