<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckClientTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->input('client-token')) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
