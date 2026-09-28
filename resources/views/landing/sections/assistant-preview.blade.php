@php($showcase = data_get($content, 'showcase'))

@if ($showcase)
    <section class="uiaikit-section uiaikit-showcase" id="assistant-preview">
        <div class="uiaikit-shell uiaikit-showcase__layout">
            <div class="uiaikit-showcase__copy">
                <p class="uiaikit-eyebrow">{{ data_get($showcase, 'eyebrow') }}</p>
                <h2>{{ data_get($showcase, 'heading') }}</h2>
                <p class="uiaikit-showcase__body">{{ data_get($showcase, 'body') }}</p>
                <ul class="uiaikit-showcase__notes">
                    @foreach (data_get($showcase, 'notes', []) as $note)
                        <li>{{ $note }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="uiaikit-showcase__demo" role="group" aria-label="Preview of the AI assistant conversation">
                <div class="uiaikit-showcase__demo-head">
                    <span class="uiaikit-showcase__avatar" aria-hidden="true">AI</span>
                    <span class="uiaikit-showcase__identity">
                        <strong>{{ data_get($branding, 'name') }}</strong>
                        <span><i></i> {{ data_get($showcase, 'status', 'Ready to help') }}</span>
                    </span>
                    <span class="uiaikit-showcase__dots" aria-hidden="true"><i></i><i></i><i></i></span>
                </div>
                <div class="uiaikit-showcase__chat">
                    <p class="uiaikit-showcase__message uiaikit-showcase__message--assistant">{{ data_get($showcase, 'greeting') }}</p>
                    <p class="uiaikit-showcase__message uiaikit-showcase__message--user">{{ data_get($showcase, 'question') }}</p>
                    <p class="uiaikit-showcase__message uiaikit-showcase__message--assistant">{{ data_get($showcase, 'answer') }}</p>
                </div>
                <div class="uiaikit-showcase__demo-foot">
                    <span>{{ data_get($showcase, 'footer_label') }}</span>
                    <span class="uiaikit-showcase__sparkle" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    </section>
@endif
