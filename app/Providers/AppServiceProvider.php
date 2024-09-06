<?php

namespace App\Providers;

use Event;
use App\Events\UserRegistered;
use Illuminate\Support\ServiceProvider;
use App\Listeners\UserRegisteredNotification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            UserRegistered::class,
            UserRegisteredNotification::class,
        );
    }
}
