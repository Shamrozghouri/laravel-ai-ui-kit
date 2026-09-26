@php($stats = data_get($content, 'stats', []))

@if (filled($stats))
    <section class="uiaikit-shell">
        <div class="uiaikit-stats">
            @foreach ($stats as $stat)
                <div class="uiaikit-stat">
                    <div class="uiaikit-stat__value">{{ $stat['value'] }}</div>
                    <div class="uiaikit-stat__label">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>
@endif
