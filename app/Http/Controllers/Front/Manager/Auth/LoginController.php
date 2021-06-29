<?php

namespace App\Http\Controllers\Front\Manager\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // ログイン画面
    public function showLoginForm()
    {
        return view('manager.auth.login');
    }

    // ログアウト
    public function logout()
    {
        // 管理者ログアウトAPIのメソッドを呼び出す
        Auth::guard('manager')->logout();
        /*$called = app()->make('Api\Manager\ManagerController');
        $result = $called->logout();*/
        return redirect()->route('manager.login');
    }
}
