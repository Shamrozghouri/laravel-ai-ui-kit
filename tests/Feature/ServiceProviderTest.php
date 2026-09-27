<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Route;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\LaravelUiAiKitServiceProvider;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\EchoDriver;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

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

    public function test_it_loads_the_package_views(): void
    {
        $this->assertTrue(view()->exists('ui-ai-kit::landing.index'));
        $this->assertTrue(view()->exists('ui-ai-kit::components.chatbot.window'));
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
