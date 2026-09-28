{{-- Chat widget. Rendered by <x-ui-ai-kit::chatbot />. --}}
<div class="uiaikit-chat"
     data-uiaikit="chat"
    data-uiaikit-theme="{{ config('ui-ai-kit.theme.mode', 'dark') }}"
     data-position="{{ $position }}"
     data-open="{{ $open ? 'true' : 'false' }}"
     data-endpoint="{{ $endpoint }}"
    data-error="{{ config('ui-ai-kit.chatbot.error_message') }}"
    style="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::themeVariables() }}--uiaikit-chat-width:{{ config('ui-ai-kit.chatbot.layout.width', '380px') }};--uiaikit-chat-height:{{ config('ui-ai-kit.chatbot.layout.height', '560px') }};--uiaikit-chat-offset:{{ config('ui-ai-kit.chatbot.layout.offset', '24px') }};">

    @include('ui-ai-kit::components.chatbot.window', [
        'name' => $name,
        'subtitle' => $subtitle,
        'welcome' => $welcome,
        'emptyMessage' => $emptyMessage,
        'footnote' => $footnote,
        'placeholder' => $placeholder,
        'suggestions' => $suggestions,
        'avatar' => $avatar,
        'closeLabel' => $closeLabel,
    ])

    @include('ui-ai-kit::components.chatbot.button', [
        'openLabel' => $openLabel,
        'closeLabel' => $closeLabel,
    ])
</div>

{!! \Shamrozghouri\LaravelUiAiKit\UiAiKit::assetTags() !!}
