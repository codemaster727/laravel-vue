<?php

namespace App\Http\Controllers\Front\Worker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // パスワードを忘れた方へ
    public function showLinkRequestForm() {
    	return view('worker.auth.passwords.email');
    }
}
