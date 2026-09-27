<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    public function test_it_publishes_config_and_assets_without_the_wizard(): void
    {
        $this->artisan('ui-ai-kit:install', ['--no-wizard' => true, '--force' => true])
            ->assertSuccessful();

        $this->assertFileExists(config_path('ui-ai-kit.php'));
        $this->assertFileExists(public_path('vendor/ui-ai-kit/css/console.css'));
        $this->assertFileExists(public_path('vendor/ui-ai-kit/js/console.js'));
    }

    public function test_the_wizard_can_generate_a_custom_driver_stub(): void
    {
        $path = app_path('UiAiKit/CustomChatDriver.php');

        if (is_file($path)) {
            unlink($path);
        }

        $this->artisan('ui-ai-kit:install', ['--force' => true])
            ->expectsQuestion('What should the assistant be called?', 'LaravelBot')
            ->expectsQuestion('Short tagline for the sidebar', 'Your Laravel Assistant in the Cloud')
            ->expectsQuestion('Accent colour (hex)', '#F53003')
            ->expectsChoice('Colour mode', 'dark', ['dark', 'light'])
            ->expectsConfirmation('Enable the full-page console UI (in addition to the floating widget)?', 'yes')
            ->expectsQuestion('Console route', 'ui-ai-kit/console')
            ->expectsConfirmation('Enable the floating chat widget?', 'yes')
            ->expectsChoice(
                'How should chat messages be answered for now?',
                'custom (generate a driver class stub in your app)',
                [
                    'echo (repeats the message back, good for testing)',
                    'forward (proxy to an HTTP endpoint you provide)',
                    'custom (generate a driver class stub in your app)',
                ]
            )
            ->expectsQuestion('Class name for your driver', 'CustomChatDriver')
            ->assertSuccessful();

        $this->assertFileExists($path);
        $this->assertStringContainsString('class CustomChatDriver implements ChatDriver', file_get_contents($path));

        unlink($path);
    }
}
