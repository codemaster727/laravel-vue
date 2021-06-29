<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    // 職人_一覧
    public function index() {
        return view('user.worker.index');
    }
    // 職人_編集
    public function updateWorker() {
        $id = request('id');
        return view('user.worker.update_worker', [
            'worker_id'     => $id,
        ]);
    }
}
