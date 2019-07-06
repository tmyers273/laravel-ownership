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
        mkdir(app_path('Traits'));

        $this->publishes([
            __DIR__.'/src/config/ownership.php' => config_path('ownership.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/src/OwnsModel.php' => app_path('Traits/OwnsModel.php'),
        ], 'trait');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/src/config/ownership.php', 'ownership'
        );
    }

}