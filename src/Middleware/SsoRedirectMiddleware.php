<?php

namespace OpenSynergic\LaravelSSO\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use Symfony\Component\HttpFoundation\Response;

class SsoRedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            $portalUrl = config('laravelsso.portal');
            Log::info('user:', ['user' => auth()->user()]);
            Log::info("SSO Redirect: User not authenticated");
            return response()->view('unauthorized::unauthorized', ['portalUrl' => $portalUrl]);
        }
        Log::info("SSO Redirect: User authenticated");
        return $next($request);
    }
}
