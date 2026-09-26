{{-- Chat widget. Rendered by <x-ui-ai-kit::chatbot />. --}}
<div class="uiaikit-chat"
     data-uiaikit="chat"
     data-position="{{ $position }}"
     data-open="{{ $open ? 'true' : 'false' }}"
     data-endpoint="{{ $endpoint }}"
     data-error="{{ config('ui-ai-kit.chatbot.error_message') }}">

    @include('ui-ai-kit::components.chatbot.window', [
        'name' => $name,
        'welcome' => $welcome,
        'placeholder' => $placeholder,
        'suggestions' => $suggestions,
        'avatar' => $avatar,
    ])

    @include('ui-ai-kit::components.chatbot.button', ['name' => $name])
</div>

{!! \Shamrozghouri\LaravelUiAiKit\UiAiKit::assetTags() !!}
