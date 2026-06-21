<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

/**
 * Handle role authorization middleware.
 */
class RoleMiddleware
{
    /**
     * Handle incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {

        /**
         * Prevent guest access.
         */
        if (!auth()->check()) {

            abort(401);
        }

        /**
         * Check authenticated user role.
         */
        if (auth()->user()->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
