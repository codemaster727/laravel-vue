<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemoController extends Controller
{
    // メモ_一覧
    public function index() {
        return view('user.memo.index');
    }
    // メモ_詳細
    public function show() {
        $memoId = request('id');
        return view('user.memo.show', [
            'memoId'    => $memoId,
        ]);
    }
    // メモ_更新
    public function update() {
        $memoId = request('id');
        return view('user.memo.update', [
            'memoId'    => $memoId,
        ]);
    }
    // メモ_登録
    public function store() {
        return view('user.memo.store');
    }
}
