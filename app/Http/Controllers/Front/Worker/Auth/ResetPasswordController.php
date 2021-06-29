<?php

namespace App\Http\Controllers\Front\Worker\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    // パスワード再登録
    public function showResetForm() {
    	return view('worker.auth.passwords.reset');
    }
}
