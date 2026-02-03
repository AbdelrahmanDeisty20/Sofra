<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class AutoCheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if ($request->user() && $request->user()->type->value !== $type) {
            return resposeJison(0, 'Unauthorized - Only ' . $type . ' can access this route');
        }

        return $next($request);
    }
}
