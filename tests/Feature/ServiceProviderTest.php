<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\LaravelUiAiKitServiceProvider;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\EchoDriver;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;
use Shamrozghouri\LaravelUiAiKit\UiAiKit;

class ServiceProviderTest extends TestCase
{
    public function test_the_service_provider_is_registered(): void
    {
        $this->assertTrue($this->app->providerIsLoaded(LaravelUiAiKitServiceProvider::class));
    }

    public function test_it_merges_the_package_configuration(): void
    {
        $this->assertSame('AI Assistant', config('ui-ai-kit.chatbot.name'));
        $this->assertSame('ui-ai-kit', config('ui-ai-kit.landing.route'));
    }

    public function test_empty_theme_environment_values_fall_back_to_valid_css_defaults(): void
    {
        config()->set('ui-ai-kit.theme.accent', '');
        config()->set('ui-ai-kit.theme.accent_hover', '');

        $variables = UiAiKit::themeVariables();

        $this->assertStringContainsString('--uiaikit-accent:#F53003;', $variables);
        $this->assertStringContainsString('--uiaikit-accent-hover:#FF4433;', $variables);
    }

    public function test_it_loads_the_package_views(): void
    {
        $this->assertTrue(view()->exists('ui-ai-kit::landing.index'));
        $this->assertTrue(view()->exists('ui-ai-kit::components.chatbot.window'));
    }

    public function test_chatbot_views_have_a_focused_publish_tag(): void
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'ui-ai-kit-chatbot-views',
            '--force' => true,
        ])->assertSuccessful();

        $this->assertFileExists(resource_path('views/vendor/ui-ai-kit/components/chatbot/chatbot.blade.php'));
        $this->assertFileExists(resource_path('views/vendor/ui-ai-kit/components/chatbot/window.blade.php'));
        $this->assertFileExists(resource_path('views/vendor/ui-ai-kit/console/index.blade.php'));
    }

    public function test_published_chatbot_views_override_the_package_default(): void
    {
        $this->artisan('vendor:publish', [
            '--tag' => 'ui-ai-kit-chatbot-views',
            '--force' => true,
        ])->assertSuccessful();

        $overridePath = resource_path('views/vendor/ui-ai-kit/components/chatbot/window.blade.php');
        $originalView = file_get_contents($overridePath);
        file_put_contents($overridePath, '<p>App-owned chatbot view</p>');
        view()->prependNamespace('ui-ai-kit', resource_path('views/vendor/ui-ai-kit'));
        view()->getFinder()->flush();

        try {
            $this->blade('<x-ui-ai-kit::chatbot />')
                ->assertSee('App-owned chatbot view')
                ->assertDontSee('Usually replies instantly');
        } finally {
            file_put_contents($overridePath, $originalView);
            $this->artisan('view:clear')->assertSuccessful();
        }
    }

    public function test_it_registers_the_package_routes(): void
    {
        $this->assertTrue(Route::has('ui-ai-kit.landing'));
        $this->assertTrue(Route::has('ui-ai-kit.chat'));
        $this->assertTrue(Route::has('ui-ai-kit.asset'));
    }

    public function test_it_resolves_the_configured_chat_driver(): void
    {
        $this->assertInstanceOf(EchoDriver::class, $this->app->make(ChatDriver::class));
    }

    public function test_it_serves_package_assets_before_publishing(): void
    {
        $response = $this->get('ui-ai-kit/assets/ui-ai-kit.css')->assertOk();

        $this->assertStringContainsString('text/css', (string) $response->headers->get('content-type'));
        $this->get('ui-ai-kit/assets/../composer.json')->assertNotFound();
    }
}
