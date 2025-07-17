<?php

namespace App\Http\Middleware;

use Closure;

class Wholesaler
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_wholesaler) {
            abort(403);
        }
        return $next($request);
    }
} 