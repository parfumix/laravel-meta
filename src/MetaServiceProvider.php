<?php

namespace Terranet\Metaable;

use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider {

    /**
     * Publish resources.
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . '../views', 'meta');

        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '../views/' => base_path('resources/views/vendor/meta'),
        ], 'views');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(MetaManagerContract::class, function() {
            return new MetaManager();
        });
    }
}