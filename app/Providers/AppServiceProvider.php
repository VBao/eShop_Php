<?php

namespace App\Providers;

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
        $this->app->bind('App\Service\IProductService', 'App\Service\Impl\ProductImpl');
        $this->app->bind('App\Service\ILaptopService', 'App\Service\Impl\LaptopImpl');
        $this->app->bind('App\Service\IDriveService', 'App\Service\Impl\DriveImpl');
        $this->app->bind('App\Service\IValidate', 'App\Service\Impl\ValidateImpl');
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
