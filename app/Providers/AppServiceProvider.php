<?php

namespace App\Providers;

use App\Notifications\TgNotification;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

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
        Notification::extend('telegram', function ($app) {
            return new TgNotification('message');
        });
    }
}
