<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('ui-ai-kit.chat_page.title', 'Laravel AI Assistant') }}</title>

    @if (config('ui-ai-kit.theme.load_fonts', true))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <link rel="stylesheet" href="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('css/ui-ai-kit.css') }}">
    <link rel="stylesheet" href="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('css/chat.css') }}">
</head>
<body class="uiaikit-chat-page" data-uiaikit-theme="{{ config('ui-ai-kit.theme.mode', 'dark') }}" style="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::themeVariables() }}">
@php
    $brand = config('ui-ai-kit.branding', []);
    $chatbot = config('ui-ai-kit.chatbot', []);
    $chatPage = config('ui-ai-kit.chat_page', []);
    $logo = $chatbot['avatar'] ?? $brand['logo'] ?? null;
    $logoIsImage = filled($logo) && (
        str_starts_with($logo, 'http://')
        || str_starts_with($logo, 'https://')
        || str_starts_with($logo, '/')
        || str_starts_with($logo, 'data:')
        || (bool) preg_match('/\.(png|jpe?g|gif|svg|webp)$/i', $logo)
    );
    $laravelMark = 'https://laravel.com/img/logomark.min.svg';
    $markImage = $logoIsImage ? $logo : (! filled($logo) && data_get($brand, 'logo_fallback', 'laravel') === 'laravel' ? $laravelMark : null);
    $markText = filled($logo) && ! $logoIsImage ? $logo : data_get($brand, 'monogram', 'L');
@endphp

<div class="uiaikit-chat-app"
     data-chat-app
     data-endpoint="{{ url(config('ui-ai-kit.api.route', 'ui-ai-kit/chat')) }}"
    data-driver="{{ config('ui-ai-kit.api.driver', 'echo') }}"
     data-error="{{ data_get($chatbot, 'error_message', 'That message did not go through. Try again.') }}"
     data-assistant="{{ data_get($chatbot, 'name', 'Laravel Assistant') }}"
    data-assistant-mark="{{ $markImage }}"
    data-assistant-monogram="{{ $markText }}"
     data-placeholder="{{ data_get($chatbot, 'placeholder', 'Message Laravel Assistant') }}"
     data-storage-key="ui-ai-kit-conversations"
     data-history-limit="{{ data_get($chatPage, 'history_limit', 30) }}">
    <div class="uiaikit-chat-backdrop" data-close-sidebar></div>

    <aside class="uiaikit-chat-sidebar" aria-label="Chat history" data-sidebar>
        <div class="uiaikit-chat-sidebar__top">
            <a class="uiaikit-chat-brand" href="{{ url(config('ui-ai-kit.chat_page.route', 'ui-ai-kit/assistant')) }}" aria-label="{{ data_get($brand, 'name', 'Laravel') }} assistant home">
                <span class="uiaikit-chat-brand__mark @if ($markImage) uiaikit-chat-brand__mark--image @else uiaikit-chat-brand__mark--text @endif">
                    @if ($markImage)
                        <img src="{{ $markImage }}" alt="">
                    @else
                        <span>{{ $markText }}</span>
                    @endif
                </span>
                <span>{{ data_get($chatbot, 'name', 'Laravel Assistant') }}</span>
            </a>

            <button type="button" class="uiaikit-chat-new" data-new-chat>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                <span>New chat</span>
                <kbd>Ctrl K</kbd>
            </button>

            <label class="uiaikit-chat-search">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.3"/><path d="m16 16 4.2 4.2"/></svg>
                <input type="search" placeholder="Search chats" data-search-history aria-label="Search chat history">
            </label>
        </div>

        <div class="uiaikit-chat-history-wrap">
            <p class="uiaikit-chat-sidebar__label">Recent</p>
            <nav class="uiaikit-chat-history" aria-label="Recent chats" data-history></nav>
            <p class="uiaikit-chat-history-empty" data-history-empty>Your conversations will appear here.</p>
        </div>

        <div class="uiaikit-chat-sidebar__bottom">
            <span class="uiaikit-chat-avatar">
                @if ($markImage)
                    <img src="{{ $markImage }}" alt="">
                @else
                    {{ $markText }}
                @endif
            </span>
            <span class="uiaikit-chat-sidebar__account">
                <strong>{{ data_get($brand, 'name', 'Laravel') }}</strong>
                <small>Powered by Laravel</small>
            </span>
        </div>
    </aside>

    <main class="uiaikit-chat-main">
        <header class="uiaikit-chat-topbar">
            <div class="uiaikit-chat-topbar__start">
                <button type="button" class="uiaikit-chat-icon-button uiaikit-chat-menu-button" data-open-sidebar aria-label="Open chat history" title="Open chat history">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="uiaikit-chat-topbar__title">{{ data_get($chatbot, 'name', 'Laravel Assistant') }}</span>
                <span class="uiaikit-chat-topbar__context"><i></i> Laravel</span>
            </div>
            <button type="button" class="uiaikit-chat-icon-button" data-theme-toggle aria-label="Switch to light mode" title="Switch theme">
                <svg class="uiaikit-chat-theme-icon uiaikit-chat-theme-icon--sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"/></svg>
                <svg class="uiaikit-chat-theme-icon uiaikit-chat-theme-icon--moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.2 15.2A8.5 8.5 0 0 1 8.8 3.8 8.5 8.5 0 1 0 20.2 15.2Z"/></svg>
            </button>
        </header>

        <section class="uiaikit-chat-thread" aria-label="Conversation">
            <div class="uiaikit-chat-empty" data-empty-state>
                <span class="uiaikit-chat-empty__mark @if ($markImage) uiaikit-chat-empty__mark--image @else uiaikit-chat-empty__mark--text @endif" aria-hidden="true">
                    @if ($markImage)
                        <img src="{{ $markImage }}" alt="">
                    @else
                        <span>{{ $markText }}</span>
                    @endif
                </span>
                <p class="uiaikit-chat-empty__eyebrow">Your Laravel coding companion</p>
                <h1>{{ data_get($chatPage, 'heading', 'How can Laravel help you?') }}</h1>
                <p class="uiaikit-chat-empty__description">{{ data_get($chatPage, 'subheading', 'Ask about Laravel, your code, or what you are building.') }}</p>
                <div class="uiaikit-chat-prompts" data-prompts>
                    @foreach (data_get($chatPage, 'suggestions', []) as $suggestion)
                        <button type="button" class="uiaikit-chat-prompt" data-prompt="{{ data_get($suggestion, 'prompt') }}" data-answer="{{ data_get($suggestion, 'answer') }}">
                            <span>{{ data_get($suggestion, 'title') }}</span>
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="uiaikit-chat-messages" data-messages role="log" aria-live="polite" aria-relevant="additions text"></div>
        </section>

        <footer class="uiaikit-chat-compose-area">
            <form class="uiaikit-chat-composer" data-composer>
                <label class="uiaikit-sr" for="uiaikit-chat-page-input">Message {{ data_get($chatbot, 'name', 'Laravel Assistant') }}</label>
                <textarea id="uiaikit-chat-page-input" data-input rows="1" maxlength="{{ data_get($chatbot, 'max_length', 2000) }}" placeholder="{{ data_get($chatbot, 'placeholder', 'Message Laravel Assistant') }}"></textarea>
                <button type="submit" class="uiaikit-chat-send" data-send aria-label="Send message" title="Send message">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5 20.5 12 4.5 4.5l2.8 7.5-2.8 7.5Z"/></svg>
                </button>
            </form>
            <p class="uiaikit-chat-disclaimer">AI can make mistakes. Verify important information before using it.</p>
        </footer>
    </main>
</div>

<script src="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('js/chat-page.js') }}" defer></script>
</body>
</html>
