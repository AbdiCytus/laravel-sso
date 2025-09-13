<?php

namespace OpenSynergic\LaravelSSO\Middleware;

use Closure;
use Illuminate\Http\Request;

class InternalAuth
{
    public function handle(Request $request, Closure $next)
    {
        $headerToken = $request->header('Authorization');

        if ($headerToken !== 'Bearer ' . config('laravelsso.api_token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
