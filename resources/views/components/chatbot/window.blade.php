<section class="uiaikit-chat__window" role="dialog" aria-label="{{ $name }}">
    @php
        $avatar = $avatar ?? null;
        $avatarIsImage = filled($avatar) && (
            str_starts_with($avatar, 'http://')
            || str_starts_with($avatar, 'https://')
            || str_starts_with($avatar, '/')
            || str_starts_with($avatar, 'data:')
            || (bool) preg_match('/\.(png|jpe?g|gif|svg|webp)$/i', $avatar)
        );
    @endphp
    <header class="uiaikit-chat__header">
        <span class="uiaikit-chat__avatar" aria-hidden="true">
            @if ($avatarIsImage)
                <img src="{{ $avatar }}" alt="">
            @elseif (filled($avatar))
                <span class="uiaikit-chat__avatar-text">{{ $avatar }}</span>
            @else
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                    <rect x="3.5" y="7" width="17" height="12.5" rx="3.5" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M12 3.5V7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <circle cx="9" cy="13" r="1.3" fill="currentColor"/>
                    <circle cx="15" cy="13" r="1.3" fill="currentColor"/>
                </svg>
            @endif
        </span>
        <span>
            <span class="uiaikit-chat__title">{{ $name }}</span>
            <span class="uiaikit-chat__status">{{ $subtitle }}</span>
        </span>
        <button type="button" class="uiaikit-chat__dismiss" data-uiaikit="dismiss" aria-label="{{ $closeLabel }}">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M6 6l12 12M6 18 18 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
        </button>
    </header>

    <div class="uiaikit-chat__log" data-uiaikit="log" role="log" aria-live="polite">
        @if (filled($welcome))
            @include('ui-ai-kit::components.chatbot.message', ['role' => 'assistant', 'body' => $welcome])
        @else
            <div class="uiaikit-chat__empty" data-uiaikit="empty">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 5.5h16v10H8.5L4 19.5v-14Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
                <p>{{ $emptyMessage }}</p>
            </div>
        @endif
    </div>

    @if (filled($suggestions))
        <div class="uiaikit-chat__suggestions" data-uiaikit="suggestions">
            @foreach ($suggestions as $suggestion)
                <button type="button" class="uiaikit-chat__suggestion" data-uiaikit="suggestion">{{ $suggestion }}</button>
            @endforeach
        </div>
    @endif

    @include('ui-ai-kit::components.chatbot.input', [
        'name' => $name,
        'placeholder' => $placeholder,
        'sendLabel' => $sendLabel,
    ])

    @if (filled($footnote))
        <p class="uiaikit-chat__footnote">{{ $footnote }}</p>
    @endif
</section>
