<?php

namespace App\Providers;

use App\Repositories\RoomRepository\IRoomRepository;
use App\Repositories\RoomRepository\RoomRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
    }
}
