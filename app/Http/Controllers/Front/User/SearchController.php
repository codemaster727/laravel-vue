<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // 検索機能
    public function index() {
        return view('user.search.index');
    }
}
