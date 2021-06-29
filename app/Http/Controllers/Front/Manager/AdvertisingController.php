<?php

namespace App\Http\Controllers\Front\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdvertisingController extends Controller
{
    // 広告_一覧
    public function index() {
    	return view('manager.advertising.index');
    }
    // 広告_更新
    public function update($id) {
    	return view('manager.advertising.update', ['id' => $id]);
    }
    // 広告_登録
    public function store() {
    	return view('manager.advertising.store');
    }
}
