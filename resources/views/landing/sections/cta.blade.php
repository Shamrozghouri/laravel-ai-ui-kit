@php($cta = data_get($content, 'cta'))

@if ($cta)
    <section class="uiaikit-cta">
        <div class="uiaikit-shell uiaikit-cta__inner">
            <h2>{{ data_get($cta, 'heading') }}</h2>
            <p>{{ data_get($cta, 'body') }}</p>
            <div class="uiaikit-cta__actions">
                @if ($primary = data_get($cta, 'primary'))
                    <a class="uiaikit-btn uiaikit-btn--primary" href="{{ $primary['href'] }}">{{ $primary['label'] }}</a>
                @endif
                @if ($secondary = data_get($cta, 'secondary'))
                    <a class="uiaikit-btn uiaikit-btn--ghost" href="{{ $secondary['href'] }}">{{ $secondary['label'] }}</a>
                @endif
            </div>
        </div>
    </section>
@endif
