<?php

namespace App\Http\Controllers\Front\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class WorkController extends Controller
{

    // 現場_一覧取得
    public function workIndex() {
    	return view('worker.work.index');
    }
    // 現場_詳細
    public function workShow(Request $request) {
        $params = $request->all();
        $work_id = $params['id'];
    	return view('worker.work.show', [
            'work_id'    => $work_id
        ]);
    }
    // 現場_写真詳細
    public function photoShow() {
    	return view('worker.work.photoShow');
    }
    // 現場_黒板追加
    public function blackboardStore(Request $request) {
        $work_id = $request->input('work_id');
    	return view('worker.work.blackboardStore', [
            'work_id'       => $work_id
        ]);
    }
    // 現場_写真移動
    public function photoPosition(Request $request) {
        $params = $request->all();
        $work_id = $params['work_id'];
        $name = $params['name'] == null ? '未定' : $params['name'];
        $content = $params['content'];

    	return view('worker.work.photoPosition', [
            'work_id'       => $work_id,
            'name'          => $name,
            'content'       => $content
        ]);
    }
}
