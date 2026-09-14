<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! isStaff()) {
            abort(403, 'Staff or owner access required.');
        }

        return $next($request);
    }
}
