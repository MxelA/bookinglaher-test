<?php

namespace App\Providers;

use App\Services\Booking\OccupancyRateService;
use App\Services\Booking\IOccupancyRateService;
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
        $this->app->bind(IOccupancyRateService::class, OccupancyRateService::class);
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
