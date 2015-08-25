<?php

namespace Laravel\Meta;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider {

    /**
     * Publish resources.
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . '../views', 'meta');

        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '../views/'      => base_path('resources/views/vendor/meta')
        ], 'views');

        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '../migrations/' => base_path('database/migrations')
        ], 'migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('meta', MetaManager::class);

        $this->registerBladeExtension();
    }

    /**
     * Register meta blade extensions .
     *
     */
    protected function registerBladeExtension() {
        if ($this->versionMatch('5.0'))
            Blade::extend(function ($view) {
                return str_replace("@meta",
                    app('meta')
                        ->render(), $view);
            });
        elseif ($this->versionMatch('5.1'))
            Blade::directive('meta', function ($expression) {
                return app('meta')
                    ->render($expression);
            });
    }

    /**
     * Check laravel version .
     *
     * @param $version
     * @return int
     */
    private function versionMatch($version) {
        $laravel = app();

        return preg_match(sprintf("/^%s/", $version), $laravel::VERSION);
    }
}