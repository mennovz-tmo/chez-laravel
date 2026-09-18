<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! is_owner()) {
            return redirect()->route('welcome')->withErrors('U heeft geen toegang om die pagina te bekijken.');
        }

        return $next($request);
    }
}
