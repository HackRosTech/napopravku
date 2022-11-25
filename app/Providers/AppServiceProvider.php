<?php

namespace App\Providers;

use App\Services\File\Contracts\UploadServiceContract;
use App\Services\File\UploadService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UploadServiceContract::class, function ($app) {
            return new UploadService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
