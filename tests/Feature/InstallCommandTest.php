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
        $this->assertFileExists(public_path('vendor/ui-ai-kit/css/chat.css'));
        $this->assertFileExists(public_path('vendor/ui-ai-kit/css/console.css'));
        $this->assertFileExists(public_path('vendor/ui-ai-kit/js/chat-page.js'));
        $this->assertFileExists(public_path('vendor/ui-ai-kit/js/console.js'));
    }

    public function test_the_wizard_can_generate_a_custom_driver_stub(): void
    {
        $driverClass = 'InstallWizardDriver'.bin2hex(random_bytes(4));
        $driverPath = app_path('UiAiKit/'.$driverClass.'.php');
        $environmentPath = base_path('.env');
        $hadEnvironment = is_file($environmentPath);
        $originalEnvironment = $hadEnvironment ? file_get_contents($environmentPath) : null;

        if (! $hadEnvironment) {
            file_put_contents($environmentPath, '');
        }

        try {
            $this->artisan('ui-ai-kit:install', ['--force' => true])
                ->expectsChoice('Which UI should open at /?', 'Full chatbot interface', ['Full landing page', 'Full chatbot interface'])
                ->expectsQuestion('What should the Laravel assistant be called?', 'LaravelBot')
                ->expectsQuestion('Short subtitle for the assistant', 'Laravel assistant for your app')
                ->expectsQuestion('Accent colour (hex)', '#F53003')
                ->expectsChoice('Colour mode', 'dark', ['dark', 'light'])
                ->expectsConfirmation('Also enable the floating chat widget?', 'no')
                ->expectsChoice(
                    'How should chat messages be answered for now?',
                    'custom (generate a driver class stub in your app)',
                    [
                        'echo (repeats the message back, good for testing)',
                        'forward (proxy to an HTTP endpoint you provide)',
                        'custom (generate a driver class stub in your app)',
                    ]
                )
                ->expectsQuestion('Class name for your driver', $driverClass)
                ->assertSuccessful();

            $this->assertFileExists($driverPath);
            $this->assertStringContainsString("class {$driverClass} implements ChatDriver", file_get_contents($driverPath));
            $environment = (string) file_get_contents($environmentPath);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_LANDING_ENABLED=false$/m', $environment);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_CHAT_PAGE_ENABLED=true$/m', $environment);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_CHAT_PAGE_ROUTE=\/$/m', $environment);
        } finally {
            if (is_file($driverPath)) {
                unlink($driverPath);
            }

            if ($hadEnvironment) {
                file_put_contents($environmentPath, $originalEnvironment);
            } elseif (is_file($environmentPath)) {
                unlink($environmentPath);
            }
        }
    }

    public function test_it_can_select_the_landing_page_without_a_wizard(): void
    {
        $environmentPath = base_path('.env');
        $hadEnvironment = is_file($environmentPath);
        $originalEnvironment = $hadEnvironment ? file_get_contents($environmentPath) : null;

        if (! $hadEnvironment) {
            file_put_contents($environmentPath, '');
        }

        try {
            $this->artisan('ui-ai-kit:install', [
                '--no-wizard' => true,
                '--force' => true,
                '--experience' => 'landing',
            ])->assertSuccessful();

            $environment = (string) file_get_contents($environmentPath);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_LANDING_ENABLED=true$/m', $environment);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_LANDING_ROUTE=\/$/m', $environment);
            $this->assertMatchesRegularExpression('/^UI_AI_KIT_CHAT_PAGE_ENABLED=false$/m', $environment);
        } finally {
            if ($hadEnvironment) {
                file_put_contents($environmentPath, $originalEnvironment);
            } elseif (is_file($environmentPath)) {
                unlink($environmentPath);
            }
        }
    }
}
