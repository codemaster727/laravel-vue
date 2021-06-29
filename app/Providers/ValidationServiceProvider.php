<?php

namespace App\Providers;

use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
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
        // TODO:カスタムバリデーションを必要に応じて記述する
        // Validator::extend('is_current_password', function ($attribute, $value, $parameters, $validator) {
        //     if (\Auth::guard('charge')->check()) {
        //         return Hash::check($value, \Auth::guard('charge')->user()->password);
        //     }
        //     return Hash::check($value, AuthService::getAuthUser()->password);
        // });
    }
}
