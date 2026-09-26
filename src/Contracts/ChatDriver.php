<?php

namespace Shamrozghouri\LaravelUiAiKit\Contracts;

interface ChatDriver
{
    /**
     * Answer a single user message.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @return array{message: string, conversation_id?: string|null}
     */
    public function send(string $message, ?string $conversationId = null, array $history = []): array;
}
