<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Shamrozghouri\LaravelUiAiKit\Contracts\ChatDriver;
use Shamrozghouri\LaravelUiAiKit\Http\Requests\ChatRequest;
use Throwable;

class ChatController extends Controller
{
    public function __invoke(ChatRequest $request, ChatDriver $driver): JsonResponse
    {
        try {
            $result = $driver->send(
                $request->string('message')->toString(),
                $request->input('conversation_id'),
                $request->input('history', []),
            );
        } catch (Throwable $e) {
            Log::error('[ui-ai-kit] chat request failed', ['exception' => $e]);

            return response()->json([
                'message' => config('ui-ai-kit.chatbot.error_message', 'That message did not go through. Try again.'),
            ], 502);
        }

        return response()->json([
            'message' => $result['message'] ?? '',
            'conversation_id' => $result['conversation_id'] ?? $request->input('conversation_id'),
        ]);
    }
}
