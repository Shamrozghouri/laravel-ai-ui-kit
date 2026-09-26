<?php

namespace Shamrozghouri\LaravelUiAiKit\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Shamrozghouri\LaravelUiAiKit\Tests\TestCase;

class ChatEndpointTest extends TestCase
{
    public function test_it_answers_with_the_default_driver(): void
    {
        $this->postJson('/ui-ai-kit/chat', ['message' => 'Hello'])
            ->assertOk()
            ->assertJsonStructure(['message', 'conversation_id']);
    }

    public function test_it_validates_the_message(): void
    {
        $this->postJson('/ui-ai-kit/chat', ['message' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }

    public function test_it_rejects_oversized_messages(): void
    {
        $this->postJson('/ui-ai-kit/chat', ['message' => str_repeat('a', 2001)])
            ->assertStatus(422)
            ->assertJsonValidationErrors('message');
    }

    public function test_the_forward_driver_proxies_to_the_configured_endpoint(): void
    {
        Http::fake([
            'https://example.test/chat' => Http::response(['message' => 'Proxied reply'], 200),
        ]);

        config()->set('ui-ai-kit.api.driver', 'forward');
        config()->set('ui-ai-kit.api.endpoint', 'https://example.test/chat');

        $this->postJson('/ui-ai-kit/chat', ['message' => 'Hello'])
            ->assertOk()
            ->assertJsonPath('message', 'Proxied reply');
    }

    public function test_it_returns_a_friendly_error_when_the_driver_fails(): void
    {
        Http::fake([
            'https://example.test/chat' => Http::response('nope', 500),
        ]);

        config()->set('ui-ai-kit.api.driver', 'forward');
        config()->set('ui-ai-kit.api.endpoint', 'https://example.test/chat');

        $this->postJson('/ui-ai-kit/chat', ['message' => 'Hello'])
            ->assertStatus(502)
            ->assertJsonPath('message', config('ui-ai-kit.chatbot.error_message'));
    }
}
