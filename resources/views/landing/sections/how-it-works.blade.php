@php($steps = data_get($content, 'how_it_works'))

@if ($steps && filled(data_get($steps, 'steps', [])))
    <section id="how-it-works" class="uiaikit-section">
        <div class="uiaikit-shell">
            <div class="uiaikit-section__head">
                <h2>{{ data_get($steps, 'heading') }}</h2>
                @if ($sub = data_get($steps, 'subheading'))
                    <p>{{ $sub }}</p>
                @endif
            </div>

            <ol class="uiaikit-steps">
                @foreach (data_get($steps, 'steps', []) as $step)
                    <li class="uiaikit-step">
                        <div>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['body'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
@endif
