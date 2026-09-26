<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class CustomRouteTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('ui-ai-kit.landing.route', 'welcome-page');
    }

    public function test_the_landing_page_lives_at_the_configured_route(): void
    {
        $this->get('/welcome-page')->assertOk();
        $this->get('/ui-ai-kit')->assertNotFound();
    }
}
