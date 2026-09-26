<?php

namespace Shamrozghouri\LaravelUiAiKit\Services\Drivers;

use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;

/**
 * The default driver. It answers locally so the widget works the moment the
 * package is installed, before any AI provider has been configured.
 */
class EchoDriver implements ChatDriver
{
    public function send(string $message, ?string $conversationId = null, array $history = []): array
    {
        return [
            'message' => 'No AI provider is connected yet, so I am repeating you back: "'.$message.'". '
                .'Set ui-ai-kit.api.driver to "forward" with an endpoint, or bind your own ChatDriver.',
            'conversation_id' => $conversationId,
        ];
    }
}
