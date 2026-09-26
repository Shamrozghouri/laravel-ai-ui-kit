<?php

namespace Shamrozghouri\LaravelUiAiKit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:'.config('ui-ai-kit.chatbot.max_length', 2000)],
            'conversation_id' => ['nullable', 'string', 'max:100'],
            'history' => ['sometimes', 'array', 'max:50'],
            'history.*.role' => ['required_with:history', 'string', 'in:user,assistant'],
            'history.*.content' => ['required_with:history', 'string', 'max:'.config('ui-ai-kit.chatbot.max_length', 2000)],
        ];
    }
}
