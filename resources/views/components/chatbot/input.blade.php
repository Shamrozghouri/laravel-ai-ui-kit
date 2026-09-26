<form class="uiaikit-chat__composer" data-uiaikit="composer">
    <label class="uiaikit-sr" for="uiaikit-chat-input">Message {{ $name }}</label>
    <textarea id="uiaikit-chat-input"
              class="uiaikit-chat__input"
              data-uiaikit="input"
              rows="1"
              maxlength="{{ config('ui-ai-kit.chatbot.max_length', 2000) }}"
              placeholder="{{ $placeholder }}"></textarea>
    <button type="submit" class="uiaikit-chat__send" data-uiaikit="send" aria-label="Send message">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M4.5 19.5 20.5 12 4.5 4.5l2.8 7.5-2.8 7.5Z" fill="currentColor"/>
        </svg>
    </button>
</form>
