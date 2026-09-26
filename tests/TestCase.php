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
}
