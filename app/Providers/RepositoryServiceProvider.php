<?php

namespace App\Providers;

use App\Repositories\BlockRepository\BlockRepository;
use App\Repositories\BlockRepository\IBlockRepository;
use App\Repositories\BookingRepository\BookingRepository;
use App\Repositories\BookingRepository\IBookingRepository;
use App\Repositories\RoomRepository\IRoomRepository;
use App\Repositories\RoomRepository\RoomRepository;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
        /**
     * Register any events for your application.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IRoomRepository::class, RoomRepository::class);
        $this->app->bind(IBookingRepository::class, BookingRepository::class);
        $this->app->bind(IBlockRepository::class, BlockRepository::class);
    }
}
