<?php

namespace Terranet\Metaable\Eloquent;

use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider {

    /**
     * Publish resources.
     */
    public function boot() {
        $this->loadViewsFrom(base_path('views'), 'meta');

        $this->publishes([
            base_path('views') => base_path('resources/views/vendor/meta'),
        ]);
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