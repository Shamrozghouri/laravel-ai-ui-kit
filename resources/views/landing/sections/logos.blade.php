@php($logos = data_get($content, 'logos.items', []))

@if (filled($logos))
    <section class="uiaikit-logos" aria-label="{{ data_get($content, 'logos.label', 'Built with') }}">
        @if ($label = data_get($content, 'logos.label'))
            <p class="uiaikit-logos__label">{{ $label }}</p>
        @endif
        <div class="uiaikit-logos__track">
            @for ($pass = 0; $pass < 2; $pass++)
                <div class="uiaikit-logos__group" @if ($pass) aria-hidden="true" @endif>
                    @foreach ($logos as $logo)
                        <span>{{ $logo }}</span>
                    @endforeach
                </div>
            @endfor
        </div>
    </section>
@endif
