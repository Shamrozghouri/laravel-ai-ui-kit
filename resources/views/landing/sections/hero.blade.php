@php($hero = data_get($content, 'hero'))

@if ($hero)
    <section class="uiaikit-hero">
        <div class="uiaikit-shell uiaikit-hero__inner">
            @if ($eyebrow = data_get($hero, 'eyebrow'))
                <p class="uiaikit-eyebrow">{{ $eyebrow }}</p>
            @endif

            <h1>{{ data_get($hero, 'heading') }}</h1>
            <p class="uiaikit-hero__sub">{{ data_get($hero, 'subheading') }}</p>

            <div class="uiaikit-hero__actions">
                @if ($primary = data_get($hero, 'primary_cta'))
                    <a class="uiaikit-btn uiaikit-btn--primary" href="{{ $primary['href'] }}">{{ $primary['label'] }}</a>
                @endif
                @if ($secondary = data_get($hero, 'secondary_cta'))
                    <a class="uiaikit-btn uiaikit-btn--ghost" href="{{ $secondary['href'] }}">{{ $secondary['label'] }}</a>
                @endif
            </div>

            @if ($command = data_get($hero, 'install_command'))
                <div class="uiaikit-install">
                    <code>{{ $command }}</code>
                    <button type="button" class="uiaikit-copy" data-uiaikit-copy="{{ $command }}">Copy</button>
                </div>
            @endif

            @if ($notes = data_get($hero, 'notes', []))
                <ul class="uiaikit-hero__notes">
                    @foreach ($notes as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endif
