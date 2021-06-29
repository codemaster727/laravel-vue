<?php

namespace App\Http\Controllers\Front\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // クライアント画面
    public function show() {
        return view('client.show');
    }

    public function dailyReport($id){
        return view('client.daily-report.show');
    }
}
