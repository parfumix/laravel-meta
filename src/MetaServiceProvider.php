<?php

namespace Laravel\Meta;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Flysap\Support;

class MetaServiceProvider extends ServiceProvider {

    /**
     * Publish resources.
     */
    public function boot() {
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '../assets/migrations/' => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../assets/configuration' => config_path('yaml/meta'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->loadConfiguration();

        Support\merge_yaml_config_from(
            config_path('yaml/meta/general.yaml') , 'laravel-meta'
        );

        $this->app->bind('meta', function() {
            return new MetaManager(
                config('laravel-meta')
            );
        });

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

    /**
     * Load configuration .
     *
     * @return $this
     */
    protected function loadConfiguration() {
        Support\set_config_from_yaml(
            __DIR__ . '/../assets/configuration/general.yaml' , 'laravel-meta'
        );

        return $this;
    }
}