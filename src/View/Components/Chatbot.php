<?php

namespace Shamrozghouri\LaravelUiAiKit\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Chatbot extends Component
{
    /** @var array<int, string> */
    public array $suggestions;

    public function __construct(
        public ?string $name = null,
        public ?string $welcome = null,
        public ?string $placeholder = null,
        public ?string $position = null,
        public ?string $endpoint = null,
        public ?bool $open = null,
        public ?string $avatar = null,
        ?array $suggestions = null,
    ) {
        $this->name ??= config('ui-ai-kit.chatbot.name', 'AI Assistant');
        $this->welcome ??= config('ui-ai-kit.chatbot.welcome_message', '');
        $this->placeholder ??= config('ui-ai-kit.chatbot.placeholder', 'Type your message');
        $this->position ??= config('ui-ai-kit.chatbot.position', 'bottom-right');
        $this->endpoint ??= url(config('ui-ai-kit.api.route', 'ui-ai-kit/chat'));
        $this->open ??= (bool) config('ui-ai-kit.chatbot.open_on_load', false);
        $this->avatar ??= config('ui-ai-kit.chatbot.avatar');
        $this->suggestions = $suggestions ?? (array) config('ui-ai-kit.chatbot.suggestions', []);
    }

    public function shouldRender(): bool
    {
        return (bool) config('ui-ai-kit.chatbot.enabled', true);
    }

    public function render(): View
    {
        return view('ui-ai-kit::components.chatbot.chatbot');
    }
}
