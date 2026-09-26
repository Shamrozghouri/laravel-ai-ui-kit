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
}
