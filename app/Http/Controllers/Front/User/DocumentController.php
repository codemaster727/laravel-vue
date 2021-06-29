<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // 書類一覧
    public function index() {
    	return view('user.document.index');
    }
}
