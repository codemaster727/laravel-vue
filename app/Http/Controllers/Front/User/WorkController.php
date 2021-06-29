<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkController extends Controller
{
    // 現場_一覧取得
    public function workIndex() {
        return view('user.work.index');
    }

    // 現場_詳細取得
    public function workShow(Request $request, $id) {
        return view('user.work.show', [ 'id' => $id ]);
    }

    // 現場_登録
    public function workStore() {
        return view('user.work.store', array('user_id' => Auth::user()->id));
    }

    // 現場_更新
    public function workUpdate($id) {
        return view('user.work.update', array('id' => $id));
    }
}
