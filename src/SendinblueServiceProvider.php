<?php

namespace Damcclean\Sendinblue;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use SendinBlue\Client\Api\AccountApi;
use SendinBlue\Client\Api\AttributesApi;
use SendinBlue\Client\Api\ContactsApi;
use SendinBlue\Client\Configuration;

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

        $this->app->singleton('sendinblue.client', function () {
            return new Client();
        });
        $this->app->singleton('sendinblue.config', function () {
            return Configuration::getDefaultConfiguration()->setApiKey('api-key', Config::get('sendinblue.apiKey'));
        });
        $this->app->singleton(AccountApi::class, function ($app) {
            $client = $app->make('sendinblue.client');
            $config = $app->make('sendinblue.config');
            return new AccountApi($client, $config);
        });
        $this->app->singleton(ContactsApi::class, function ($app) {
            $client = $app->make('sendinblue.client');
            $config = $app->make('sendinblue.config');
            return new ContactsApi($client, $config);
        });
        $this->app->singleton(AttributesApi::class, function ($app) {
            $client = $app->make('sendinblue.client');
            $config = $app->make('sendinblue.config');
            return new AttributesApi($client, $config);
        });
        $this->app->bind('sendinblue', Sendinblue::class);
    }
}
