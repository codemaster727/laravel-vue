<?php

namespace App\Http\ViewComposers;

use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * 各ページ共通で使用するデータを定義
 */
class LayoutController
{
    public function compose(View $view)
    {
        // TODO:渡したい変数を定義し、$view->withのパラメータに追記する
        $user = null;
        $view->with([
            'loginUser'       => $user,
        ]);
    }
}
