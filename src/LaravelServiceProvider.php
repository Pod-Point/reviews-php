<?php

namespace PodPoint\Reviews;

/**
 * Class ServiceProvider
 * @package PodPoint\ReviewsLaravel
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
        $this->mergeConfigFrom(
            __DIR__ . '/config/review-providers.php',
            'reviews-providers'
        );

        $this->app->singleton('reviews', function () {
            return new Manager(config('review-providers'));
        });
    }
}
