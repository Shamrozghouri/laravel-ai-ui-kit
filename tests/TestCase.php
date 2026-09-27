<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Shamrozghouri\LaravelUiAiKit\LaravelUiAiKitServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [LaravelUiAiKitServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(
            random_bytes(32)
        ));
        $app['config']->set('logging.default', 'null');
    }
}
