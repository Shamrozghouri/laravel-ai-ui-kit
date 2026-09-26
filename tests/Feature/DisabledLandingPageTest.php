<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class DisabledLandingPageTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('ui-ai-kit.landing.enabled', false);
    }

    public function test_no_landing_route_is_registered(): void
    {
        $this->assertFalse(Route::has('ui-ai-kit.landing'));
        $this->get('/ui-ai-kit')->assertNotFound();
    }
}
