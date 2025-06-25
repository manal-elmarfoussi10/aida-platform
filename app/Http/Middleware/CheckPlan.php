<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPlan
{
    public function handle(Request $request, Closure $next, ...$plans): Response
    {
        if (!in_array(auth()->user()?->plan, $plans)) {
            abort(403, 'Your plan does not allow access to this feature.');
        }

        return $next($request);
    }
}
