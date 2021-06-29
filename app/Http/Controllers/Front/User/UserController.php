<?php

namespace App\Http\Controllers\Front\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    // ユーザー新規登録_基本情報入力
    public function storeInfo() {
        date_default_timezone_set('Asia/Tokyo');
        $time_before_8hours = date('Y-m-d H:i:s', strtotime('-8 hour'));

        $token = request('token', '');
        $status = 0;
        $user = User::where('email_token', $token)->where('email_verified_flag', '1')->first();
        if (isset($user)) {
            $status = 1; // 8時間を超える前に本登録が完了した場合
        }else{
            $valid_user = User::where('email_token', $token)
            ->where('email_verified_at', '>=', $time_before_8hours)
            ->first();
            if(!isset($valid_user)){
                $status = 2; // 8時間以内に本登録が完了しなかった場合
            }
        }
        return view('user.store.info', [
            'token'      => $token,
            'status'      => $status
        ]);
    }

    // ユーザー新規登録_営業担当者入力
    public function storeMember() {
        return view('user.store.member');
    }

    // ユーザー新規登録_成功
    public function storeSuccess() {
        return view('user.store.success');
    }

    // ユーザー新規登録_失敗
    public function storeFailed() {
        return view('user.store.failed');
    }
}
