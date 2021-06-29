<?php

namespace App\Http\Controllers\Front\Manager\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // パスワードを忘れた方へ
    public function showLinkRequestForm() {
    	return view('manager.auth.passwords.email');
    }
}
