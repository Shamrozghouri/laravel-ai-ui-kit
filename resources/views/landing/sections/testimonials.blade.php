@php($testimonials = data_get($content, 'testimonials'))

@if ($testimonials && filled(data_get($testimonials, 'items', [])))
    <section id="reviews" class="uiaikit-section">
        <div class="uiaikit-shell">
            <div class="uiaikit-section__head">
                <h2>{{ data_get($testimonials, 'heading') }}</h2>
                @if ($sub = data_get($testimonials, 'subheading'))
                    <p>{{ $sub }}</p>
                @endif
            </div>

            <div class="uiaikit-quotes">
                @foreach (data_get($testimonials, 'items', []) as $item)
                    <figure class="uiaikit-quote">
                        <blockquote>{{ $item['quote'] }}</blockquote>
                        <figcaption>
                            <span class="uiaikit-quote__avatar" aria-hidden="true">{{ Str::substr($item['name'], 0, 1) }}</span>
                            <span>
                                <span class="uiaikit-quote__name">{{ $item['name'] }}</span><br>
                                <span class="uiaikit-quote__role">{{ $item['role'] }}</span>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
