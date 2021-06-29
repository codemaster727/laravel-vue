<?php

namespace App\Http\Controllers\Front\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    // SMS_一覧
    public function index() {
    	return view('manager.sms.index');
    }
}
