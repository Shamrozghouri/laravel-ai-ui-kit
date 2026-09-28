@php($hero = data_get($content, 'hero'))

@if ($hero)
    <section class="uiaikit-hero">
        <div class="uiaikit-shell uiaikit-hero__layout">
            <div class="uiaikit-hero__inner">
                @if ($eyebrow = data_get($hero, 'eyebrow'))
                    <p class="uiaikit-eyebrow">{{ $eyebrow }}</p>
                @endif

                <h1>{{ data_get($hero, 'heading') }}</h1>
                <p class="uiaikit-hero__sub">{{ data_get($hero, 'subheading') }}</p>

                <div class="uiaikit-hero__actions">
                    @if ($primary = data_get($hero, 'primary_cta'))
                        <a class="uiaikit-btn uiaikit-btn--primary" href="{{ $primary['href'] }}" data-uiaikit-conversion="hero">{{ $primary['label'] }}</a>
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

            <div class="uiaikit-hero__visual" data-uiaikit-hero-stage aria-hidden="true">
                <div class="uiaikit-hero__orbit uiaikit-hero__orbit--outer"></div>
                <div class="uiaikit-hero__orbit uiaikit-hero__orbit--inner"></div>
                <div class="uiaikit-hero__mascot-fallback">
                    <span class="uiaikit-hero__ear uiaikit-hero__ear--left"></span>
                    <span class="uiaikit-hero__ear uiaikit-hero__ear--right"></span>
                    <span class="uiaikit-hero__eye uiaikit-hero__eye--left"></span>
                    <span class="uiaikit-hero__eye uiaikit-hero__eye--right"></span>
                    <span class="uiaikit-hero__cheek uiaikit-hero__cheek--left"></span>
                    <span class="uiaikit-hero__cheek uiaikit-hero__cheek--right"></span>
                    <span class="uiaikit-hero__smile"></span>
                </div>
                <canvas class="uiaikit-hero__canvas" data-uiaikit-hero-canvas></canvas>
                <span class="uiaikit-hero__sticker uiaikit-hero__sticker--top">{{ data_get($hero, 'sticker_top', 'Made for your business') }}</span>
                <span class="uiaikit-hero__sticker uiaikit-hero__sticker--bottom">{{ data_get($hero, 'sticker_bottom', 'Thoughtful by design') }}</span>
            </div>
        </div>
    </section>
@endif
