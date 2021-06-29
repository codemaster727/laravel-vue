<?php

namespace App\Http\Controllers\Front\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // ログイン画面
    public function showLoginForm()
    {
        return view('user.auth.login');
    }
}