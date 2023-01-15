<?php

namespace Guava\Mailcheap;

use Illuminate\Support\ServiceProvider;

class MailcheapServiceProvider extends ServiceProvider
{


    public function register(): void
    {
        $this->app->bind('mailcheap', function () {
            return new Mailcheap();
        });

        $this->mergeConfigFrom(__DIR__. '/../config/config.php', 'mailcheap');
    }

    public function boot(): void {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('mailcheap.php'),
            ], 'config');

        }
    }

}
