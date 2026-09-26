<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('ui-ai-kit.console.title', 'LaravelBot — Console') }}</title>

    @if (config('ui-ai-kit.theme.load_fonts', true))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    <link rel="stylesheet" href="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('css/console.css') }}">
</head>
<body class="uiaikitc" data-uiaikitc-theme="{{ config('ui-ai-kit.theme.mode', 'dark') }}" style="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::themeVariables() }}">

@php
    $brand = config('ui-ai-kit.console.brand', []);
    $nav = config('ui-ai-kit.console.nav', []);
    $user = config('ui-ai-kit.console.user', []);
    $about = config('ui-ai-kit.console.about', []);
    $quickActions = config('ui-ai-kit.console.quick_actions', []);
    $promo = config('ui-ai-kit.console.promo', []);
    $footer = config('ui-ai-kit.console.footer', []);
    $welcome = config('ui-ai-kit.console.welcome_message', '');
    $placeholder = config('ui-ai-kit.console.placeholder', 'Type your message...');
    $logo = $brand['logo'] ?? config('ui-ai-kit.branding.logo');

    $layout = config('ui-ai-kit.console.layout', []);
    $showSidebar = $layout['show_sidebar'] ?? true;
    $showPanel = $layout['show_panel'] ?? true;
    $showHeader = $layout['show_header'] ?? true;

    $icons = [
        'chat' => '<path d="M4 4.5h16a1.5 1.5 0 0 1 1.5 1.5v9a1.5 1.5 0 0 1-1.5 1.5H9l-4.2 3.2A.6.6 0 0 1 4 19.2V16H4a1.5 1.5 0 0 1-1.5-1.5V6A1.5 1.5 0 0 1 4 4.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
        'dashboard' => '<rect x="3.5" y="3.5" width="7.5" height="7.5" rx="1.6" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="3.5" width="7.5" height="4.7" rx="1.6" stroke="currentColor" stroke-width="1.6"/><rect x="13" y="10.2" width="7.5" height="10.3" rx="1.6" stroke="currentColor" stroke-width="1.6"/><rect x="3.5" y="13" width="7.5" height="7.5" rx="1.6" stroke="currentColor" stroke-width="1.6"/>',
        'book' => '<path d="M4 5.2c0-.9.8-1.6 1.8-1.6H11v14.8H5.8c-1 0-1.8.7-1.8 1.6V5.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M20 5.2c0-.9-.8-1.6-1.8-1.6H13v14.8h5.2c1 0 1.8.7 1.8 1.6V5.2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
        'settings' => '<circle cx="12" cy="12" r="3.2" stroke="currentColor" stroke-width="1.6"/><path d="M12 3.5v2M12 18.5v2M20.5 12h-2M5.5 12h-2M17.6 6.4l-1.4 1.4M7.8 16.2l-1.4 1.4M17.6 17.6l-1.4-1.4M7.8 7.8 6.4 6.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'history' => '<circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6"/><path d="M12 7.5V12l3.2 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'terminal' => '<rect x="3" y="4.5" width="18" height="15" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M6.5 9.5 10 12l-3.5 2.5M12.5 14.5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'rocket' => '<path d="M12 2.8c2.6 1.4 4.3 4.2 4.3 8.1 0 1.8-.4 3.3-1 4.6l-3.3 3.7-3.3-3.7c-.6-1.3-1-2.8-1-4.6 0-3.9 1.7-6.7 4.3-8.1Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="12" cy="10.5" r="1.7" stroke="currentColor" stroke-width="1.6"/><path d="M8.6 16.5 6 19.5M15.4 16.5l2.6 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
    ];
@endphp

<div class="uiaikitc-app @unless($showSidebar) uiaikitc-app--no-sidebar @endunless @unless($showPanel) uiaikitc-app--no-panel @endunless"
     data-uiaikitc="app"
     data-endpoint="{{ url(config('ui-ai-kit.api.route', 'ui-ai-kit/chat')) }}"
     data-error="{{ config('ui-ai-kit.chatbot.error_message', 'That message did not go through. Try again.') }}">

    {{-- ===== Sidebar ===== --}}
    @if ($showSidebar)
        <aside class="uiaikitc-side">
            <div class="uiaikitc-side__top">
                <a class="uiaikitc-brand" href="#">
                    <span class="uiaikitc-brand__mark" aria-hidden="true">
                        @if ($logo)
                            <img src="{{ $logo }}" alt="{{ $brand['name'] ?? 'LaravelBot' }}">
                        @else
                            <svg viewBox="0 0 32 32" fill="none"><path d="M16 3 27 9v14L16 29 5 23V9L16 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M16 3v13M16 16 5 9M16 16l11-7M16 16v13" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                        @endif
                    </span>
                    <span class="uiaikitc-brand__text">
                        <span class="uiaikitc-brand__name">
                            {{ Str::before($brand['name'] ?? 'LaravelBot', $brand['name_accent'] ?? 'Bot') }}<em>{{ $brand['name_accent'] ?? 'Bot' }}</em>
                        </span>
                        <span class="uiaikitc-brand__tagline">{{ $brand['tagline'] ?? '' }}</span>
                    </span>
                </a>

                <nav class="uiaikitc-nav" aria-label="Console">
                    @foreach ($nav as $item)
                        <a href="{{ $item['href'] ?? '#' }}" class="uiaikitc-nav__item @if (!empty($item['active'])) is-active @endif">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">{!! $icons[$item['icon'] ?? 'chat'] ?? $icons['chat'] !!}</svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="uiaikitc-side__bottom">
                <span class="uiaikitc-side__glyph" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none"><path d="M16 3 27 9v14L16 29 5 23V9L16 3Z" stroke="currentColor" stroke-width="1.6"/></svg>
                </span>
                <p class="uiaikitc-side__tagline">{{ $brand['footer_tagline'] ?? '' }}</p>
            </div>

            <div class="uiaikitc-side__scape" aria-hidden="true"></div>
        </aside>
    @endif

    {{-- ===== Main column ===== --}}
    <div class="uiaikitc-main">
        @if ($showHeader)
            <header class="uiaikitc-header">
                <div class="uiaikitc-header__brand">
                    <span class="uiaikitc-header__icon" aria-hidden="true">
                        @if ($logo)
                            <img src="{{ $logo }}" alt="{{ $brand['name'] ?? 'LaravelBot' }}">
                        @else
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M7 17.5a4.5 4.5 0 0 1-.6-8.96 5.5 5.5 0 0 1 10.7-1.9A4 4 0 0 1 17 17.5H7Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
                        @endif
                    </span>
                    <span>
                        <span class="uiaikitc-header__title">{{ $brand['name'] ?? 'LaravelBot' }}</span>
                        <span class="uiaikitc-header__subtitle">{{ $brand['header_subtitle'] ?? '' }}</span>
                    </span>
                </div>

                <div class="uiaikitc-header__actions">
                    <span class="uiaikitc-status"><i></i>{{ $user['status'] ?? 'Online' }}</span>
                    <button type="button" class="uiaikitc-user">
                        <span class="uiaikitc-user__avatar">{{ $user['initial'] ?? 'A' }}</span>
                        <span>{{ $user['name'] ?? 'Admin' }}</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </header>
        @endif

        <main class="uiaikitc-chat" data-uiaikitc="log" role="log" aria-live="polite">
            @if (filled($welcome))
                <div class="uiaikitc-msg uiaikitc-msg--assistant">
                    <span class="uiaikitc-avatar uiaikitc-avatar--bot" aria-hidden="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M7 17.5a4.5 4.5 0 0 1-.6-8.96 5.5 5.5 0 0 1 10.7-1.9A4 4 0 0 1 17 17.5H7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                    </span>
                    <div class="uiaikitc-msg__body">
                        <div class="uiaikitc-bubble">{!! nl2br(e($welcome)) !!}</div>
                        <span class="uiaikitc-time">{{ now()->format('g:i A') }}</span>
                    </div>
                </div>
            @endif
        </main>

        <form class="uiaikitc-composer" data-uiaikitc="composer">
            <button type="button" class="uiaikitc-composer__attach" aria-label="Attach a file" tabindex="-1">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8 12.5 14.5 6a3 3 0 1 1 4.2 4.2L11 18a4.5 4.5 0 1 1-6.4-6.4l7.1-7.1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <label class="uiaikitc-sr" for="uiaikitc-input">Message {{ $brand['name'] ?? 'LaravelBot' }}</label>
            <input id="uiaikitc-input" class="uiaikitc-composer__input" type="text" data-uiaikitc="input"
                   placeholder="{{ $placeholder }}" autocomplete="off">
            <button type="submit" class="uiaikitc-composer__send" data-uiaikitc="send" aria-label="Send message">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4.5 19.5 20.5 12 4.5 4.5l2.8 7.5-2.8 7.5Z" fill="currentColor"/></svg>
            </button>
        </form>
    </div>

    {{-- ===== Right panel ===== --}}
    @if ($showPanel)
        <aside class="uiaikitc-panel">
            <div class="uiaikitc-panel__about">
                <span class="uiaikitc-panel__glyph" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none"><path d="M16 3 27 9v14L16 29 5 23V9L16 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M16 3v13M16 16 5 9M16 16l11-7M16 16v13" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/></svg>
                </span>
                <h2>{{ $about['heading'] ?? 'LaravelBot' }}</h2>
                <p class="uiaikitc-panel__kicker">{{ $about['subheading'] ?? '' }}</p>
                <p class="uiaikitc-panel__body">{{ $about['body'] ?? '' }}</p>
            </div>

            @if (filled($quickActions))
                <div class="uiaikitc-panel__section">
                    <h3><svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z" fill="currentColor"/></svg> Quick Actions</h3>
                    <div class="uiaikitc-quick" data-uiaikitc="quick-actions">
                        @foreach ($quickActions as $action)
                            <button type="button" class="uiaikitc-quick__item" data-uiaikitc-prompt="{{ $action['prompt'] ?? '' }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">{!! $icons[$action['icon'] ?? 'chat'] ?? $icons['chat'] !!}</svg>
                                <span>{{ $action['label'] }}</span>
                                <svg class="uiaikitc-quick__chev" width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m9 6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (!empty($promo) && filled($promo['heading'] ?? null))
                <div class="uiaikitc-promo">
                    <span class="uiaikitc-promo__icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M7 17.5a4.5 4.5 0 0 1-.6-8.96 5.5 5.5 0 0 1 10.7-1.9A4 4 0 0 1 17 17.5H7Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
                    </span>
                    <div>
                        <strong>{{ $promo['heading'] ?? '' }}</strong>
                        <span>{{ $promo['body'] ?? '' }}</span>
                    </div>
                </div>
            @endif

            <div class="uiaikitc-panel__footer">
                <span class="uiaikitc-panel__glyph uiaikitc-panel__glyph--sm" aria-hidden="true">
                    <svg viewBox="0 0 32 32" fill="none"><path d="M16 3 27 9v14L16 29 5 23V9L16 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                </span>
                <strong>{{ $footer['heading'] ?? 'LaravelBot' }}</strong>
                <span>{{ $footer['tagline'] ?? '' }}</span>
            </div>
        </aside>
    @endif
</div>

<script src="{{ \Shamrozghouri\LaravelUiAiKit\UiAiKit::asset('js/console.js') }}" defer></script>
</body>
</html>
