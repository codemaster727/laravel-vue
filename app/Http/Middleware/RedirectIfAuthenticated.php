<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;

class RedirectIfAuthenticated
{
    /**
     * ログイン時のリダイレクト先決定などの処理を行う
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // 管理者の場合のリダイレクト
            if ($guard === 'admin') {
                return redirect()->route('manager.user.index');
            } elseif ($guard === 'worker') {
                // 作業者の場合のリダイレクト
                return redirect()->route('worker.work.index');
            }
            // ユーザーの場合のリダイレクト
            return redirect()->route('user.work.index');
        }
        return $next($request);
    }
}
