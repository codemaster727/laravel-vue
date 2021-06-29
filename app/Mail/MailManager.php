<?php

namespace App\Mail;

use Log;
use Mail;
use App\User;

class MailManager
{
    // ユーザー向けパスワードリセット用メール送信を行う
    public static function send_reset_password($user) {
        $mailData = [
            'email'     => $user['email'],
            'company'   => $user['company'],
            'url'       => url('/password-reset') . '?token=' . $user['email_token'],
        ];

        try {
            Mail::send('emails.user.reset_password', $mailData, function($message) use ($user)
            {
                $message->to($user['email'])->subject('パスワード再設定');
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    // 管理者向けパスワードリセット用メール送信を行う
    public static function send_reset_password_to_manager($manager) {
        $mailData = [
            'email'     => $manager['email'],
            'url'       => route('manager.password.reset') . '?token=' . $manager['email_token'],
        ];

        try {
            Mail::send('emails.manager.reset_password', $mailData, function($message) use ($manager)
            {
                $message->to($manager['email'])->subject('Password Reset');
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    // ユーザー向けパスワードリセット用メール送信を行う
    public static function send_advertising($advertising) {
        $mailData = [
            'email'     => $advertising->email,
            'company'   => $advertising->company,
            'url'       => url('/sponcer/confirm') . '?id=' . $advertising->id,
        ];

        try {
            Mail::send('emails.manager.advertising', $mailData, function($message) use ($advertising)
            {
                $message->to($advertising->email)->subject('広告出稿確認');
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    // ユーザー向け情報を入力メール送信を行う
    public static function send_register_user($user) {
        $mailData = [
            'url'       => url('/register-info') . '?token=' . $user->email_token
        ];

        try {
            Mail::send('emails.user.register_info', $mailData, function($message) use ($user)
            {
                $message->to($user->email)->subject('【ぬりえもん】会員登録のご案内');
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

}
