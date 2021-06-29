<?php

namespace App\Http\Controllers\Front\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    // パスワード再登録
    public function showResetForm() {
    	return view('user.auth.passwords.reset');
    }
}
