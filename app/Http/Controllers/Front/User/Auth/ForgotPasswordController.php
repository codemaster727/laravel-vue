<?php

namespace App\Http\Controllers\Front\User\Auth;

use DateTime;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    // パスワードを忘れた方へ
    public function showLinkRequestForm() {
    	return view('user.auth.passwords.email');
    }

    public function showLinkResetForm() {
        $token = request('token', '');

        // token有効性検査
        $user = User::where('email_token', $token)->first();
        if (!isset($user)) {
            return view('user.auth.passwords.email', [
                'status'    => 1,   // 無効なユーザー
            ]);
        }

        $date1 = new DateTime($user->email_verified_at);
        $date2 = new DateTime(date('Y-m-d H:i:s'));
        $diff = $date2->diff($date1);
        $hours = $diff->h + $diff->days * 24;
        if ($hours > 1) {
            return view('user.auth.passwords.email', [
                'status'    => 2,   // 一時間経過
            ]);
        }

        return view('user.auth.passwords.reset', [
            'email'     => $user->email,
        ]);
    }
}
