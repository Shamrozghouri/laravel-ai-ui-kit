@php($footer = data_get($content, 'footer'))

<footer class="uiaikit-footer">
    <div class="uiaikit-shell">
        <div class="uiaikit-footer__grid">
            <div>
                <span class="uiaikit-brand">
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
                </span>
                <p class="uiaikit-footer__blurb">{{ data_get($footer, 'blurb', data_get($branding, 'tagline')) }}</p>
            </div>

            @foreach (data_get($footer, 'columns', []) as $column)
                <div>
                    <h4>{{ $column['title'] }}</h4>
                    <ul>
                        @foreach (data_get($column, 'links', []) as $link)
                            <li><a href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <div class="uiaikit-footer__base">{{ data_get($footer, 'copyright') }}</div>
    </div>
</footer>
