@php($nav = data_get($content, 'nav', []))
@php($navCta = data_get($content, 'nav_cta'))

<header class="uiaikit-nav">
    <div class="uiaikit-shell uiaikit-nav__inner">
        <a class="uiaikit-brand" href="{{ url(config('ui-ai-kit.landing.route', 'ui-ai-kit')) }}">
            <span class="uiaikit-brand__mark">
                @if (data_get($branding, 'logo'))
                    <img src="{{ data_get($branding, 'logo') }}" alt="{{ data_get($branding, 'name') }}">
                @elseif (data_get($branding, 'logo_fallback', 'laravel') === 'laravel')
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel">
                @else
                    {{ data_get($branding, 'monogram', Str::substr(data_get($branding, 'name', 'A'), 0, 1)) }}
                @endif
            </span>
            {{ data_get($branding, 'name') }}
        </a>

        @if (filled($nav))
            <nav class="uiaikit-nav__links" aria-label="Primary">
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>
        @endif

        <div class="uiaikit-nav__actions">
            <button type="button" class="uiaikit-theme-toggle" data-uiaikit-theme-toggle aria-label="Switch to light mode" title="Switch to light mode">
                <svg class="uiaikit-theme-toggle__sun" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
                <svg class="uiaikit-theme-toggle__moon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.2 15.2A8.5 8.5 0 0 1 8.8 3.8 8.5 8.5 0 1 0 20.2 15.2Z"></path>
                </svg>
                <span class="uiaikit-sr-only" data-uiaikit-theme-label>Switch to light mode</span>
            </button>
            @if ($navCta)
                <a class="uiaikit-btn uiaikit-btn--primary uiaikit-btn--sm" href="{{ $navCta['href'] }}" data-uiaikit-conversion="nav">{{ $navCta['label'] }}</a>
            @endif
        </div>
    </div>
</header>
