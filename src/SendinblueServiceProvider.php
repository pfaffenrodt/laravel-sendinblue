<?php

namespace Damcclean\Sendinblue;

use Illuminate\Support\ServiceProvider;

class SendinblueServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('sendinblue.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'sendinblue');

        $this->app->singleton('sendinblue', function () {
            return new Sendinblue;
        });
    }
}
