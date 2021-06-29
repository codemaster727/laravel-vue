<?php

namespace App\Http\Controllers\Front\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    // 職人新規登録_リクエスト
    public function storeRequest() {
        return view('worker.store.request');
    }
    // 職人新規登録_基本情報入力
    public function storeInfo() {
        return view('worker.store.info');
    }
    // 職人新規登録_登録完了
    public function storeComplete(Request $request) {
        $params = $request->all();
        $work_id = $params['id'];
        return view('worker.store.complete', [
            'worker_id'     => $work_id
        ]);
    }
}
