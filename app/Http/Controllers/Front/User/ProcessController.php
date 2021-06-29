<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcessController extends Controller
{

    // 工程表_一覧取得
    public function index() {
        return view('user.process.index');
    }

    // 工程表_詳細取得
    public function show($id) {
        return view('user.process.show', array('id' => $id));
    }

    // 工程表_登録
    public function store($workId) {
        return view('user.process.store', array('workId' => $workId));
    }

    // 工程表_更新
    public function update($id) {
        return view('user.process.update', array('id' => $id));
    }

}
