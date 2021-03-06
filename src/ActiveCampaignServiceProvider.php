<?php

namespace farouqzakwan\ActiveCampaign;

use Illuminate\Support\ServiceProvider;

class ActiveCampaignServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'farouqzakwan');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'farouqzakwan');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/activecampaign.php', 'activecampaign');

        // Register the service the package provides.
        $this->app->singleton('activecampaign', function ($app) {
            return new ActiveCampaign;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['activecampaign'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/activecampaign.php' => config_path('activecampaign.php'),
        ], 'activecampaign.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/farouqzakwan'),
        ], 'activecampaign.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/farouqzakwan'),
        ], 'activecampaign.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/farouqzakwan'),
        ], 'activecampaign.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
