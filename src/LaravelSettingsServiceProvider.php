<?php

namespace Dalholm\LaravelSettings;

use Dalholm\LaravelSettings\Cache\CacheProfileInterface;
use Illuminate\Cache\Repository;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class LaravelSettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        //$this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-settings.php'),
                __DIR__ . '/../database/migrations/2021_09_24_000000_create_settings_table.php' => database_path('migrations/2021_09_24_000000_create_settings_table.php'),
            ], 'laravel-settings');


            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-settings'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-settings'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-settings'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-settings');

        $this->app->bind(CacheProfileInterface::class, function (Container $app) {
            return $app->make(config('laravel-settings.cache_profile'));
        });

        $this->app->when(CacheRepository::class)
            ->needs(Repository::class)
            ->give(function (): Repository {
                return app('cache')->store(config('laravel-settings.cache_store'));
            });

        // Register the main class to use with the facade
        $this->app->singleton('laravelsettings', LaravelSettings::class);
    }
}
