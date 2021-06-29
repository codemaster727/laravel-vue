<?php

namespace App\Http\Middleware;

use Closure;
use Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; //View::share用

class GetIsMobile
{
    public function handle($request, Closure $next)
    {
        $agent = app('agent');
        View::share(['isMobile' => $agent->isMobile()]);

        return $next($request);
    }
}