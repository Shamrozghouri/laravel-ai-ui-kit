<?php

namespace Shamrozghouri\LaravelUiAiKit\Services\Drivers;

use Illuminate\Http\Client\Factory as HttpFactory;
use RuntimeException;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;

/**
 * Proxies the message to an HTTP endpoint you control, server side, so API
 * credentials never reach the browser.
 */
class ForwardDriver implements ChatDriver
{
    /**
     * @param  array<string, string>  $headers
     */
    public function __construct(
        protected HttpFactory $http,
        protected ?string $endpoint,
        protected int $timeout = 30,
        protected array $headers = [],
    ) {
    }

    public function send(string $message, ?string $conversationId = null, array $history = []): array
    {
        if (blank($this->endpoint)) {
            throw new RuntimeException('No endpoint configured. Set ui-ai-kit.api.endpoint or UI_AI_KIT_CHAT_ENDPOINT.');
        }

        $response = $this->http
            ->timeout($this->timeout)
            ->withHeaders($this->headers)
            ->acceptJson()
            ->post($this->endpoint, [
                'message' => $message,
                'conversation_id' => $conversationId,
                'history' => $history,
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Chat endpoint returned status '.$response->status().'.');
        }

        return [
            'message' => (string) ($response->json('message') ?? $response->json('reply') ?? ''),
            'conversation_id' => $response->json('conversation_id') ?? $conversationId,
        ];
    }
}
