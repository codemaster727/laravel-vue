<?php

namespace App\Http\Controllers\Front\Manager;

use Log;
use Auth;
use Session;
use App\Models\Manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    // ユーザー_一覧
    public function index() {
        return view('manager.user.index');
    }
    // ユーザー_更新
    public function update($id) {
        return view('manager.user.update', ['id' => $id]);
    }
    // ユーザー_登録
    public function store() {
        $manager_id = Auth::guard('manager')->user()->id;
        // session(['manager_name' => $manager_name]);
        return view('manager.user.store', compact('manager_id'));
    }
}
