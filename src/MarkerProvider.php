<?php
namespace imer\Marker;

use Illuminate\Support\ServiceProvider;

class MarkerProvider extends ServiceProvider {
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'marker');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/marker'),
        ]);
        $this->publishes([
            __DIR__ . '/../resources/assets/js' => resource_path('assets/js/marker'),
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/translations', 'marker');

        $this->publishes([
            __DIR__ . '/config.php' => config_path('marker.php'),
        ]);

        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'marker'
        );
    }
}