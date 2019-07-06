<?php

namespace TMyers273\Ownership;

use Illuminate\Support\ServiceProvider;

class OwnershipServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        @mkdir(app_path('Traits'));

        $this->publishes([
            __DIR__.'/config/ownership.php' => config_path('ownership.php'),
        ], 'laravel-ownership-config');

        $this->publishes([
            __DIR__.'/OwnsModels.php' => app_path('Traits/OwnsModels.php'),
        ], 'laravel-ownership-trait');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/ownership.php', 'ownership'
        );
    }

}