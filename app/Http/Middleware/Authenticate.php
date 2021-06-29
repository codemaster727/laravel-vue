<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == 'web' && Auth::guard('web')->user() == null) {
            return redirect('/login');
        }
        if ($guard == 'worker' && Auth::guard('worker')->user() == null) {
            return redirect('/worker/login');
        }
        if ($guard == 'manager' && Auth::guard('manager')->user() == null) {
            return redirect('/manager/login');
        }
        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
