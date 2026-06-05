<?php

namespace Hexters\FeedbackNow;

use Hexters\FeedbackNow\Http\Middleware\InjectFeedbackButton;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class FeedbackNowServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/config.php', 'feedback-now');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'feedback-now');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Auto-inject the button on every page. One install, every page.
        // Registered as global middleware so it does not depend on the host
        // app's middleware-group setup. The middleware itself only touches
        // full HTML responses, so API/JSON/binary responses are untouched.
        $this->app->booted(function () {
            $this->app->make(Kernel::class)->pushMiddleware(InjectFeedbackButton::class);
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/Config/config.php' => config_path('feedback-now.php'),
            ], 'feedback-now-config');
        }
    }
}
