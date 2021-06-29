<?php

namespace App\Http\Controllers\Front\Sponcer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SponcerController extends Controller
{
    // 広告_一覧
    public function index() {
    	return view('sponcer.index');
    }
    // 広告_確認画面
    public function confirm() {
        $advertise_id = request('id', 0);
    	return view('sponcer.confirm', [
    	    'advertise_id'      => $advertise_id,
        ]);
    }
    // 広告_完了
    public function complete() {
    	return view('sponcer.complete');
    }
}
