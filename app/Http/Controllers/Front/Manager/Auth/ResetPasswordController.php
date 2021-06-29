<?php

namespace App\Http\Controllers\Front\Manager\Auth;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    // パスワード再登録
    public function showResetForm(Request $request)
    {
        $manager = Manager::where('email_token', $request->token)->first();
        $email = $manager->email;
        return view('manager.auth.passwords.reset')->with(
            ['email' => $email]
        );
    }
}
