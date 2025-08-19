<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Check if user is authenticated
        if (! $request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // 2. Check if user has the required role
        if ($request->user()->role !== $role) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}



