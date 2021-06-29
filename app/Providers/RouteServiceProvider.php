<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    // TODO:ユーザーのルートが確定後、記述を変更する
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // Binding route param with Model object

        Route::bind('memo', function ($value) {
            $memo = \App\Models\Memo::find($value);
            /*if ($memo->user_id != \Auth::user()->id) {
                throw new BadRequestErrorResponseException([
                    'id' => 'Invalid id param'
                ]);
            }*/
            return $memo;
        });

        Route::bind('processmaster', function ($value) {
            $processMaster = \App\Models\ProcessMaster::find($value);
            /*if ($processMaster->user_id != \Auth::user()->id) {
                throw new BadRequestErrorResponseException([
                    'id' => 'Invalid id param'
                ]);
            }*/
            return $processMaster;
        });

        Route::bind('workreportmaster', function ($value) {
            $workReportMaster = \App\Models\WorkReportMaster::find($value);
            /*if ($workReportMaster->user_id != \Auth::user()->id) {
                throw new BadRequestErrorResponseException([
                    'id' => 'Invalid id param'
                ]);
            }*/
            return $workReportMaster;
        });

        Route::bind('workreportphoto', function ($value) {
            $workReportPhoto = \App\Models\WorkReportPhoto::find($value);
            return $workReportPhoto;
        });

        Route::bind('shortmessage', function ($value) {
            $shortMessage = \App\Models\ShortMessage::find($value);
            /*if ($shortMessage->user_id != \Auth::user()->id) {
                throw new BadRequestErrorResponseException([
                    'id' => 'Invalid id param'
                ]);
            }*/
            return $shortMessage;
        });

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
