<?php

namespace App\Http\Controllers\Front\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // プロフィール_詳細
    public function profileShow() {
        return view('worker.profile.show');
    }
    // プロフィール_更新
    public function profileUpdate() {
        return view('worker.profile.update');
    }
}
