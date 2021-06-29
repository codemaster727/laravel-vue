<?php

namespace App\Http\Controllers\Front\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    // 管理者_一覧
    public function index() {
    	return view('manager.manager.index');
    }
    // 管理者_更新
    public function update($id) {
    	return view('manager.manager.update', ['id' => $id]);
    }
    // 管理者_登録
    public function store() {
    	return view('manager.manager.store');
    }
}
