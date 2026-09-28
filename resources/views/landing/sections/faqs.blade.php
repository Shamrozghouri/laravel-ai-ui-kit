@php($faqs = data_get($content, 'faqs'))

@if ($faqs && filled(data_get($faqs, 'items', [])))
    <section id="faq" class="uiaikit-section uiaikit-faq">
        <div class="uiaikit-shell">
            <div class="uiaikit-section__head">
                <h2>{{ data_get($faqs, 'heading') }}</h2>
                @if ($subheading = data_get($faqs, 'subheading'))
                    <p>{{ $subheading }}</p>
                @endif
            </div>

            <div class="uiaikit-faq__list">
                @foreach (data_get($faqs, 'items', []) as $item)
                    <details class="uiaikit-faq__item">
                        <summary>{{ $item['question'] }}</summary>
                        <p>{{ $item['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
@endif
