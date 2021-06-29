<?php

namespace App\Http\Controllers\Front\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // お客様_一覧
    public function index() {
        return view('user.client.index');
    }
}
