<?php

namespace OpenSynergic\LaravelSSO\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClientKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providedKey = $request->header('key'); // ambil dari header
        $validKey = 'client_api_key';     // definisikan di config

        if (!$providedKey || $providedKey !== $validKey) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}
