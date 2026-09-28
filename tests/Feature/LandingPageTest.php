<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class LandingPageTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('ui-ai-kit.landing.enabled', true);
        $app['config']->set('ui-ai-kit.landing.route', 'ui-ai-kit');
        $app['config']->set('ui-ai-kit.chat_page.enabled', false);
    }

    public function test_the_landing_page_renders(): void
    {
        $this->get('/ui-ai-kit')
            ->assertOk()
            ->assertSee(config('ui-ai-kit.content.hero.heading'))
            ->assertSee('id="assistant-preview"', false)
            ->assertSee('Meet your AI sidekick')
            ->assertSee('Laravel Agent Evals')
            ->assertSee('Test your real Laravel AI agent, check expected behavior')
            ->assertSee('composer require shamrozghouri/laravel-agent-evals')
            ->assertSee('data-uiaikit-copy', false)
            ->assertSee('uiaikit-feature__install', false)
            ->assertSee('id="faq"', false)
            ->assertSee('The landing page')
            ->assertSee('Page + AI assistant')
            ->assertSee('Client projects')
            ->assertSee('per project')
            ->assertSee('Hosting and any AI provider usage are billed separately')
            ->assertSee('data-uiaikit-hero-canvas', false)
            ->assertSee('data-uiaikit-conversion="hero"', false)
            ->assertSee('data-uiaikit-theme-toggle', false)
            ->assertSee('https://laravel.com/img/logomark.min.svg', false)
            ->assertSee('Built by Shamroz Ghouri')
            ->assertSee('Creator, Laravel UI AI Kit')
            ->assertSee('Laravel Package Developer')
            ->assertSee('Open-source Maintainer')
            ->assertDontSee('Maya Rodriguez')
            ->assertDontSee('James Chen')
            ->assertDontSee('Sarah Kim')
            ->assertDontSee('Buy Studio')
            ->assertSee('uiaikit-chat', false);
    }

    public function test_the_route_uri_comes_from_configuration(): void
    {
        $this->assertSame(
            config('ui-ai-kit.landing.route'),
            Route::getRoutes()->getByName('ui-ai-kit.landing')->uri()
        );
    }

    public function test_an_unpaired_final_feature_spans_the_full_grid_width(): void
    {
        $this->get('/ui-ai-kit/assets/landing.css')
            ->assertOk()
            ->assertSee('.uiaikit-feature:last-child:nth-child(odd)', false)
            ->assertSee('grid-column: 1 / -1', false);
    }

    public function test_content_comes_from_configuration(): void
    {
        config()->set('ui-ai-kit.content.hero.heading', 'A heading from config');

        $this->get('/ui-ai-kit')->assertSee('A heading from config');
    }

    public function test_custom_brands_can_use_a_monogram_instead_of_the_laravel_logo(): void
    {
        config()->set('ui-ai-kit.branding.name', 'Acme Studio');
        config()->set('ui-ai-kit.branding.monogram', 'A');
        config()->set('ui-ai-kit.branding.logo_fallback', 'monogram');

        $this->get('/ui-ai-kit')
            ->assertOk()
            ->assertDontSee('https://laravel.com/img/logomark.min.svg', false)
            ->assertSee('Acme Studio');
    }

    public function test_sections_are_skipped_when_their_content_is_empty(): void
    {
        config()->set('ui-ai-kit.content.pricing', null);
        config()->set('ui-ai-kit.content.faqs', null);

        $this->get('/ui-ai-kit')->assertDontSee('id="pricing"', false);
        $this->get('/ui-ai-kit')->assertDontSee('id="faq"', false);
    }

    public function test_sections_can_be_reordered_and_unknown_sections_are_ignored(): void
    {
        config()->set('ui-ai-kit.content.sections', ['faqs', 'hero', 'invalid-section']);

        $html = $this->get('/ui-ai-kit')->assertOk()->getContent();

        $this->assertLessThan(strpos($html, 'class="uiaikit-hero"'), strpos($html, 'id="faq"'));
        $this->assertStringNotContainsString('invalid-section', $html);
    }

    public function test_cta_can_render_a_csrf_protected_lead_form(): void
    {
        config()->set('session.driver', 'array');
        config()->set('ui-ai-kit.content.cta.form', [
            'action' => '/contact',
            'method' => 'POST',
            'submit_label' => 'Request a quote',
            'fields' => [
                ['name' => 'email', 'label' => 'Work email', 'type' => 'email', 'required' => true],
                ['name' => 'message', 'label' => 'Project details', 'type' => 'textarea'],
            ],
        ]);

        $this->withSession(['status' => 'Thanks, we will be in touch.'])
            ->get('/ui-ai-kit')
            ->assertOk()
            ->assertSee('action="/contact"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="message"', false)
            ->assertSee('data-uiaikit-lead-form', false)
            ->assertSee('Request a quote')
            ->assertSee('Thanks, we will be in touch.');
    }

    public function test_output_is_escaped(): void
    {
        config()->set('ui-ai-kit.content.hero.heading', '<script>alert(1)</script>');

        $this->get('/ui-ai-kit')->assertDontSee('<script>alert(1)</script>', false);
    }
}
