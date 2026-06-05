<?php

namespace Hexters\FeedbackNow\Tests;

use Hexters\FeedbackNow\FeedbackNowServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [FeedbackNowServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(random_bytes(32)));
        $app['config']->set('feedback-now.provider', 'github');
        $app['config']->set('feedback-now.token', 'test-token');
        $app['config']->set('feedback-now.repo', 'acme/shop');
    }

    protected function defineRoutes($router): void
    {
        $router->middleware('web')->get('/_fbn_page', fn () => '<html><head></head><body>page</body></html>');
    }
}
