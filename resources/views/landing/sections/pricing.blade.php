@php($pricing = data_get($content, 'pricing'))

@if ($pricing && filled(data_get($pricing, 'tiers', [])))
    <section id="pricing" class="uiaikit-section uiaikit-section--flush">
        <div class="uiaikit-shell">
            <div class="uiaikit-section__head">
                <h2>{{ data_get($pricing, 'heading') }}</h2>
                @if ($sub = data_get($pricing, 'subheading'))
                    <p>{{ $sub }}</p>
                @endif
            </div>

            <div class="uiaikit-pricing">
                @foreach (data_get($pricing, 'tiers', []) as $tier)
                    <div class="uiaikit-plan @if (data_get($tier, 'featured')) uiaikit-plan--featured @endif">
                        @if (data_get($tier, 'featured'))
                            <span class="uiaikit-plan__tag">Most popular</span>
                        @endif

                        <div class="uiaikit-plan__name">{{ $tier['name'] }}</div>

                        <div class="uiaikit-plan__price">
                            <strong>{{ $tier['price'] }}</strong>
                            <span>{{ data_get($tier, 'period') }}</span>
                        </div>

                        <p class="uiaikit-plan__desc">{{ data_get($tier, 'description') }}</p>

                        @if ($cta = data_get($tier, 'cta'))
                            <a href="{{ $cta['href'] }}"
                               class="uiaikit-btn uiaikit-btn--block {{ data_get($tier, 'featured') ? 'uiaikit-btn--primary' : 'uiaikit-btn--ghost' }}">
                                {{ $cta['label'] }}
                            </a>
                        @endif

                        <ul class="uiaikit-plan__features">
                            @foreach (data_get($tier, 'features', []) as $feature)
                                <li data-included="{{ data_get($feature, 'included') ? 'true' : 'false' }}">
                                    @if (data_get($feature, 'included'))
                                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <path d="M3 8.5 6.2 11.5 13 4.5" stroke="var(--uiaikit-accent)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @else
                                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <path d="M4 12 12 4M4 4l8 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" opacity="0.5"/>
                                        </svg>
                                    @endif
                                    <span>{{ $feature['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
