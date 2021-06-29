<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // 営業担当_一覧
    public function index() {
    	return view('user.member.index');
    }
}
