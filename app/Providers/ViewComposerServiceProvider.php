<?php

namespace App\Providers;

// use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\LayoutController;

/**
 * 共通してviewにデータを渡す等の処理が必要な場合、class単位で定義する
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composers([
            LayoutController::class => '*',
        ]);
    }
}
