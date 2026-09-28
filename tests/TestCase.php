<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Shamrozghouri\LaravelUiAiKit\LaravelUiAiKitServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('view:clear')->assertSuccessful();
    }

    protected function getPackageProviders($app): array
    {
        return [LaravelUiAiKitServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $packageConfig = require dirname(__DIR__).'/config/ui-ai-kit.php';

        $app['config']->set('ui-ai-kit.content', $packageConfig['content']);
        $app['config']->set('ui-ai-kit.chat_page.suggestions', $packageConfig['chat_page']['suggestions']);
        $app['config']->set('app.key', 'base64:'.base64_encode(
            random_bytes(32)
        ));
        $app['config']->set('logging.default', 'null');
        $app['config']->set('cache.default', 'array');
        $app['config']->set('ui-ai-kit.api.driver', 'echo');
    }
}
