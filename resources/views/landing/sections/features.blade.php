@php($features = data_get($content, 'features'))

@if ($features && filled(data_get($features, 'items', [])))
    <section id="features" class="uiaikit-section uiaikit-section--flush">
        <div class="uiaikit-shell">
            <div class="uiaikit-section__head">
                <h2>{{ data_get($features, 'heading') }}</h2>
                @if ($sub = data_get($features, 'subheading'))
                    <p>{{ $sub }}</p>
                @endif
            </div>

            <div class="uiaikit-grid">
                @foreach (data_get($features, 'items', []) as $index => $feature)
                    <article class="uiaikit-feature">
                        <span class="uiaikit-feature__index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $feature['title'] }}</h3>
                        <p>{{ $feature['body'] }}</p>
                        @if ($command = data_get($feature, 'command'))
                            <div class='uiaikit-install uiaikit-feature__install'>
                                <code>{{ $command }}</code>
                                <button type='button' class='uiaikit-copy' data-uiaikit-copy='{{ $command }}'>Copy</button>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
