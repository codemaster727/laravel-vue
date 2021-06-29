<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\FrontBaseController;

// TODO:初期の環境構築のOK/NG判断の為、表示用のControllerなので最後に除外する
class TopController extends FrontBaseController
{
    public function index()
    {
        return view('welcome');
    }
}
