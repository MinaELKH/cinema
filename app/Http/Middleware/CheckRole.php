<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Non authentifié'], 401);
        }

        if (!in_array(auth()->user()->role, $roles)) {
            return response()->json(['error' => 'Accès interdit'], 403);
        }

        return $next($request);
    }

}
