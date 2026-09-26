<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class ConsolePageTest extends TestCase
{
    public function test_the_console_page_renders(): void
    {
        $this->get('/ui-ai-kit/console')
            ->assertOk()
            ->assertSee(config('ui-ai-kit.console.brand.name'))
            ->assertSee('uiaikitc-app', false);
    }

    public function test_the_route_uri_comes_from_configuration(): void
    {
        $this->assertSame(
            config('ui-ai-kit.console.route'),
            Route::getRoutes()->getByName('ui-ai-kit.console')->uri()
        );
    }

    public function test_quick_actions_come_from_configuration(): void
    {
        config()->set('ui-ai-kit.console.quick_actions', [
            ['label' => 'Custom Action', 'icon' => 'chat', 'prompt' => 'Hello'],
        ]);

        $this->get('/ui-ai-kit/console')->assertSee('Custom Action');
    }

    public function test_output_is_escaped(): void
    {
        config()->set('ui-ai-kit.console.brand.name', '<script>alert(1)</script>');

        $this->get('/ui-ai-kit/console')->assertDontSee('<script>alert(1)</script>', false);
    }
}
