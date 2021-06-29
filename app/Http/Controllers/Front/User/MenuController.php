<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // メニュー_詳細
    public function index() {
        return view('user.menu.index');
    }
    // メニュー_営業担当登録
    public function storeMember() {
        return view('user.menu.storeMember');
    }
    // メニュー_営業担当更新
    public function updateMember() {
        $id = request('id');
        return view('user.menu.updateMember', [
            'member_id'     => $id,
        ]);
    }
    // メニュー_プロフィール編集
    public function updateProfile() {
        return view('user.menu.updateProfile');
    }
    // メニュー_パスワード編集
    public function updatePassword() {
        return view('user.menu.updatePassword');
    }
    // メニュー_退会
    public function withdraw() {
        return view('user.menu.withdraw');
    }
    // メニュー_銀行口座一覧
    public function indexBank() {
        $user = Auth::user();
        return view('user.menu.indexBank', compact('user'));
    }
    // メニュー_銀行口座編集
    public function updateBank($id) {
        // $bank_type = request('type');
        // $bank_id = request('id');
        // return view('user.menu.updateBank', [
        //     'bank_type'     => $bank_type,
        //     'bank_id'       => $bank_id,
        // ]);
        return view('user.menu.updateBank', compact('id'));
    }
    // メニュー_銀行口座登録
    public function storeBank() {
        return view('user.menu.storeBank');
    }
    // メニュー_お客様追加
    public function storeClient() {
        return view('user.menu.storeClient');
    }
    // メニュー_お客様更新
    public function updateClient() {
        $id = request('id');
        return view('user.menu.updateClient', [
            'client_id'     => $id,
        ]);
    }
    // メニュー_職人追加
    public function storeWorker() {
        return view('user.menu.storeWorker');
    }
    // メニュー_撮影項目マスター一覧
    public function indexPhotoMaster() {
        return view('user.menu.indexPhotoMaster');
    }
    // メニュー_工程名マスター一覧
    public function indexProcessMaster() {
        return view('user.menu.indexProcessMaster');
    }
}
