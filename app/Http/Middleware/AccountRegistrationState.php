<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class AccountRegistrationState
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Config::get('auth.account_creation_enabled')) {
            abort(403, 'Account registration has been disabled by the server administrator!');
        }

        return $next($request);
    }
}
