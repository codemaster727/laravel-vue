<?php

namespace App\Http\Controllers\Front\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    // 職人_一覧
    public function index() {
    	return view('manager.worker.index');
    }
    // 職人_更新s
    public function update() {
    	return view('manager.worker.update');
    }
}
