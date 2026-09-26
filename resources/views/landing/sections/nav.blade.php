@php($nav = data_get($content, 'nav', []))
@php($navCta = data_get($content, 'nav_cta'))

<header class="uiaikit-nav">
    <div class="uiaikit-shell uiaikit-nav__inner">
        <a class="uiaikit-brand" href="{{ url(config('ui-ai-kit.landing.route', 'ui-ai-kit')) }}">
            <span class="uiaikit-brand__mark">
                @if (data_get($branding, 'logo'))
                    <img src="{{ data_get($branding, 'logo') }}" alt="{{ data_get($branding, 'name') }}">
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

        @if ($navCta)
            <div class="uiaikit-nav__actions">
                <a class="uiaikit-btn uiaikit-btn--primary uiaikit-btn--sm" href="{{ $navCta['href'] }}">{{ $navCta['label'] }}</a>
            </div>
        @endif
    </div>
</header>
