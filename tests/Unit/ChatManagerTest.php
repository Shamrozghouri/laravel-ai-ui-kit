<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Unit;

use InvalidArgumentException;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\Services\ChatManager;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\EchoDriver;
use Shamrozghouri\LaravelUiAiKit\Services\Drivers\ForwardDriver;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class ChatManagerTest extends TestCase
{
    public function test_it_resolves_the_built_in_drivers(): void
    {
        $manager = $this->app->make(ChatManager::class);

        $this->assertInstanceOf(EchoDriver::class, $manager->driver('echo'));
        $this->assertInstanceOf(ForwardDriver::class, $manager->driver('forward'));
    }

    public function test_it_resolves_a_custom_driver(): void
    {
        $manager = $this->app->make(ChatManager::class);

        $manager->extend('custom', fn () => new class implements ChatDriver
        {
            public function send(string $message, ?string $conversationId = null, array $history = []): array
            {
                return ['message' => 'custom: '.$message];
            }
        });

        $this->assertSame('custom: hi', $manager->driver('custom')->send('hi')['message']);
    }

    public function test_it_rejects_an_unknown_driver(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->app->make(ChatManager::class)->driver('nope');
    }
}
