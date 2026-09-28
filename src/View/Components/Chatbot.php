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
        public ?string $subtitle = null,
        public ?string $emptyMessage = null,
        public ?string $footnote = null,
        public ?string $openLabel = null,
        public ?string $closeLabel = null,
        public ?string $sendLabel = null,
    ) {
        $this->name ??= config('ui-ai-kit.chatbot.name', 'AI Assistant');
        $this->subtitle ??= config('ui-ai-kit.chatbot.subtitle', 'Usually replies instantly');
        $this->welcome ??= config('ui-ai-kit.chatbot.welcome_message', '');
        $this->emptyMessage ??= config('ui-ai-kit.chatbot.empty_message', 'Ask a question to get started.');
        $this->footnote ??= config('ui-ai-kit.chatbot.footnote', 'Answers are generated and may be wrong.');
        $this->placeholder ??= config('ui-ai-kit.chatbot.placeholder', 'Type your message');
        $this->position ??= config('ui-ai-kit.chatbot.position', 'bottom-right');
        $this->endpoint ??= url(config('ui-ai-kit.api.route', 'ui-ai-kit/chat'));
        $this->open ??= (bool) config('ui-ai-kit.chatbot.open_on_load', false);
        $this->avatar ??= config('ui-ai-kit.chatbot.avatar') ?? config('ui-ai-kit.branding.logo');
        $this->openLabel ??= str_replace(':name', $this->name, config('ui-ai-kit.chatbot.open_label', 'Open :name'));
        $this->closeLabel ??= str_replace(':name', $this->name, config('ui-ai-kit.chatbot.close_label', 'Close :name'));
        $this->sendLabel ??= config('ui-ai-kit.chatbot.send_label', 'Send message');
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
