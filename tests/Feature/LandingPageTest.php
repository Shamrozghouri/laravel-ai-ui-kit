<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_the_landing_page_renders(): void
    {
        $this->get('/ui-ai-kit')
            ->assertOk()
            ->assertSee(config('ui-ai-kit.content.hero.heading'))
            ->assertSee('uiaikit-chat', false);
    }

    public function test_the_route_uri_comes_from_configuration(): void
    {
        $this->assertSame(
            config('ui-ai-kit.landing.route'),
            Route::getRoutes()->getByName('ui-ai-kit.landing')->uri()
        );
    }

    public function test_content_comes_from_configuration(): void
    {
        config()->set('ui-ai-kit.content.hero.heading', 'A heading from config');

        $this->get('/ui-ai-kit')->assertSee('A heading from config');
    }

    public function test_sections_are_skipped_when_their_content_is_empty(): void
    {
        config()->set('ui-ai-kit.content.pricing', null);

        $this->get('/ui-ai-kit')->assertDontSee('id="pricing"', false);
    }

    public function test_output_is_escaped(): void
    {
        config()->set('ui-ai-kit.content.hero.heading', '<script>alert(1)</script>');

        $this->get('/ui-ai-kit')->assertDontSee('<script>alert(1)</script>', false);
    }
}
