@php($cta = data_get($content, 'cta'))

@if ($cta)
    <section class="uiaikit-cta">
        <div class="uiaikit-shell uiaikit-cta__inner @if (data_get($cta, 'form')) uiaikit-cta__inner--with-form @endif">
            <h2>{{ data_get($cta, 'heading') }}</h2>
            <p>{{ data_get($cta, 'body') }}</p>
            <div class="uiaikit-cta__actions">
                @if ($primary = data_get($cta, 'primary'))
                    <a class="uiaikit-btn uiaikit-btn--primary" href="{{ $primary['href'] }}" data-uiaikit-conversion="footer">{{ $primary['label'] }}</a>
                @endif
                @if ($secondary = data_get($cta, 'secondary'))
                    <a class="uiaikit-btn uiaikit-btn--ghost" href="{{ $secondary['href'] }}">{{ $secondary['label'] }}</a>
                @endif
            </div>

            @if (($form = data_get($cta, 'form')) && filled(data_get($form, 'action')))
                @php($formMethod = strtoupper(data_get($form, 'method', 'POST')) === 'GET' ? 'GET' : 'POST')
                <form class="uiaikit-lead-form" action="{{ data_get($form, 'action') }}" method="{{ $formMethod }}" data-uiaikit-lead-form>
                    @if ($formMethod === 'POST')
                        @csrf
                    @endif

                    @if ($message = session(data_get($form, 'status_key', 'status')))
                        <p class="uiaikit-lead-form__status" role="status">{{ $message }}</p>
                    @endif

                    <div class="uiaikit-lead-form__fields">
                        @foreach (data_get($form, 'fields', []) as $field)
                            @php($fieldName = data_get($field, 'name'))
                            @php($fieldType = data_get($field, 'type', 'text'))
                            @php($fieldId = 'uiaikit-lead-'.$loop->index)
                            <div class="uiaikit-lead-form__field @if ($fieldType === 'textarea') uiaikit-lead-form__field--wide @endif">
                                <label for="{{ $fieldId }}">{{ data_get($field, 'label') }}</label>

                                @if ($fieldType === 'textarea')
                                    <textarea id="{{ $fieldId }}" name="{{ $fieldName }}" placeholder="{{ data_get($field, 'placeholder') }}" @if (data_get($field, 'required')) required @endif>{{ old($fieldName) }}</textarea>
                                @elseif ($fieldType === 'select')
                                    <select id="{{ $fieldId }}" name="{{ $fieldName }}" @if (data_get($field, 'required')) required @endif>
                                        @foreach (data_get($field, 'options', []) as $option)
                                            <option value="{{ data_get($option, 'value') }}" {{ old($fieldName) == data_get($option, 'value') ? 'selected' : '' }}>{{ data_get($option, 'label') }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    @php($inputType = in_array($fieldType, ['text', 'email', 'tel', 'url', 'number'], true) ? $fieldType : 'text')
                                    <input id="{{ $fieldId }}" type="{{ $inputType }}" name="{{ $fieldName }}" value="{{ old($fieldName) }}" placeholder="{{ data_get($field, 'placeholder') }}" autocomplete="{{ data_get($field, 'autocomplete', 'off') }}" @if (data_get($field, 'required')) required @endif>
                                @endif

                                @error($fieldName)
                                    <span class="uiaikit-lead-form__error" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <button class="uiaikit-btn uiaikit-btn--primary" type="submit">{{ data_get($form, 'submit_label', 'Send request') }}</button>

                    @if (data_get($form, 'privacy_text') && data_get($form, 'privacy_href'))
                        <p class="uiaikit-lead-form__privacy">{{ data_get($form, 'privacy_text') }} <a href="{{ data_get($form, 'privacy_href') }}">{{ data_get($form, 'privacy_label', 'Privacy policy') }}</a></p>
                    @endif
                </form>
            @endif
        </div>
    </section>
@endif
