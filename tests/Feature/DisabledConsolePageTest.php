<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class DisabledConsolePageTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('ui-ai-kit.console.enabled', false);
    }

    public function test_no_console_route_is_registered(): void
    {
        $this->assertFalse(Route::has('ui-ai-kit.console'));
        $this->get('/ui-ai-kit/console')->assertNotFound();
    }
}
