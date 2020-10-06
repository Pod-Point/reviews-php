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
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/review-providers.php', 'review-providers'
        );

        $this->app->singleton(Manager::class, function() {
            return new Manager(config('review-providers'));
        });
    }
}
