<section class="uiaikit-chat__window" role="dialog" aria-label="{{ $name }}">
    <header class="uiaikit-chat__header">
        <span class="uiaikit-chat__avatar" aria-hidden="true">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                <rect x="3.5" y="7" width="17" height="12.5" rx="3.5" stroke="currentColor" stroke-width="1.7"/>
                <path d="M12 3.5V7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                <circle cx="9" cy="13" r="1.3" fill="currentColor"/>
                <circle cx="15" cy="13" r="1.3" fill="currentColor"/>
            </svg>
        </span>
        <span>
            <span class="uiaikit-chat__title">{{ $name }}</span>
            <span class="uiaikit-chat__status">{{ config('ui-ai-kit.chatbot.subtitle', 'Online') }}</span>
        </span>
        <button type="button" class="uiaikit-chat__dismiss" data-uiaikit="dismiss" aria-label="Close {{ $name }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M6 18 18 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </button>
    </header>

    <div class="uiaikit-chat__log" data-uiaikit="log" role="log" aria-live="polite">
        @if (filled($welcome))
            @include('ui-ai-kit::components.chatbot.message', ['role' => 'assistant', 'body' => $welcome])
        @endif
    </div>

    @if (filled($suggestions))
        <div class="uiaikit-chat__suggestions" data-uiaikit="suggestions">
            @foreach ($suggestions as $suggestion)
                <button type="button" class="uiaikit-chat__suggestion" data-uiaikit="suggestion">{{ $suggestion }}</button>
            @endforeach
        </div>
    @endif

    <form class="uiaikit-chat__composer" data-uiaikit="composer">
        <label class="uiaikit-sr" for="uiaikit-chat-input">Message {{ $name }}</label>
        <textarea id="uiaikit-chat-input"
                  class="uiaikit-chat__input"
                  data-uiaikit="input"
                  rows="1"
                  maxlength="{{ config('ui-ai-kit.chatbot.max_length', 2000) }}"
                  placeholder="{{ $placeholder }}"></textarea>
        <button type="submit" class="uiaikit-chat__send" data-uiaikit="send" aria-label="Send message">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4.5 19.5 20.5 12 4.5 4.5l2.8 7.5-2.8 7.5Z" fill="currentColor"/>
            </svg>
        </button>
    </form>

    <p class="uiaikit-chat__footnote">Answers are generated and may be wrong.</p>
</section>
