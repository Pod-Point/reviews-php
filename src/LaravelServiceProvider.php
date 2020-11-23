<?php

namespace PodPoint\Reviews;

use PodPoint\Reviews\Cache\CacheProvider;
use PodPoint\Reviews\Cache\LaravelCacheAdapter;

/**
 * Class ServiceProvider.
 */
class LaravelServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/review-providers.php' => config_path('review-providers.php'),
        ], 'reviews-config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setCacheAdapter();

        $this->mergeConfigFrom(
            __DIR__ . '/config/review-providers.php',
            'reviews-providers'
        );

        $this->app->singleton('reviews', function () {
            return new Reviews(config('review-providers'));
        });
    }

    /**
     * Sets the default laravel cache adapter.
     */
    protected function setCacheAdapter()
    {
        CacheProvider::setInstance(new LaravelCacheAdapter());
    }
}
