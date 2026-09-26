/* Laravel UI AI Kit — chatbot widget.
   No dependencies. Every message is inserted with textContent, never innerHTML. */

(function () {
    'use strict';

    function boot(root) {
        if (root.dataset.uiaikitReady === 'true') return;
        root.dataset.uiaikitReady = 'true';

        var launcher = root.querySelector('[data-uiaikit="launcher"]');
        var dismiss = root.querySelector('[data-uiaikit="dismiss"]');
        var log = root.querySelector('[data-uiaikit="log"]');
        var form = root.querySelector('[data-uiaikit="composer"]');
        var input = root.querySelector('[data-uiaikit="input"]');
        var send = root.querySelector('[data-uiaikit="send"]');
        var suggestions = root.querySelector('[data-uiaikit="suggestions"]');

        var endpoint = root.dataset.endpoint;
        var errorText = root.dataset.error || 'That message did not go through. Try again.';
        var conversationId = null;
        var history = [];
        var pending = false;
        var lastMessage = '';

        function token() {
            var meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute('content') : null;
        }

        function scroll() {
            log.scrollTop = log.scrollHeight;
        }

        function addMessage(role, text, variant) {
            var wrap = document.createElement('div');
            wrap.className = 'uiaikit-msg uiaikit-msg--' + role + (variant ? ' uiaikit-msg--' + variant : '');

            var bubble = document.createElement('div');
            bubble.className = 'uiaikit-msg__bubble';
            bubble.textContent = text;
            wrap.appendChild(bubble);

            log.appendChild(wrap);
            scroll();
            return wrap;
        }

        function addTyping() {
            var wrap = document.createElement('div');
            wrap.className = 'uiaikit-msg uiaikit-msg--assistant';
            wrap.setAttribute('data-uiaikit-typing', 'true');

            var dots = document.createElement('div');
            dots.className = 'uiaikit-msg__bubble uiaikit-typing';
            dots.appendChild(document.createElement('span'));
            dots.appendChild(document.createElement('span'));
            dots.appendChild(document.createElement('span'));

            var label = document.createElement('span');
            label.className = 'uiaikit-sr';
            label.textContent = 'Assistant is typing';
            dots.appendChild(label);

            wrap.appendChild(dots);
            log.appendChild(wrap);
            scroll();
            return wrap;
        }

        function addError() {
            var wrap = addMessage('assistant', errorText, 'error');
            var retry = document.createElement('button');
            retry.type = 'button';
            retry.className = 'uiaikit-chat__retry';
            retry.textContent = 'Try again';
            retry.addEventListener('click', function () {
                wrap.remove();
                if (lastMessage) submit(lastMessage, true);
            });
            wrap.appendChild(retry);
            scroll();
        }

        function setPending(state) {
            pending = state;
            send.disabled = state;
            input.disabled = state;
        }

        function hideSuggestions() {
            if (suggestions) suggestions.remove();
            suggestions = null;
        }

        function hideEmptyState() {
            var empty = log.querySelector('[data-uiaikit="empty"]');
            if (empty) empty.remove();
        }

        function submit(text, isRetry) {
            if (pending || !text.trim()) return;

            lastMessage = text;
            hideSuggestions();
            hideEmptyState();

            if (!isRetry) {
                addMessage('user', text);
                history.push({ role: 'user', content: text });
            }

            input.value = '';
            input.style.height = 'auto';
            setPending(true);

            var typing = addTyping();
            var headers = { 'Content-Type': 'application/json', Accept: 'application/json' };
            var csrf = token();
            if (csrf) headers['X-CSRF-TOKEN'] = csrf;

            fetch(endpoint, {
                method: 'POST',
                headers: headers,
                credentials: 'same-origin',
                body: JSON.stringify({
                    message: text,
                    conversation_id: conversationId,
                    history: history.slice(-20),
                }),
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) throw new Error(data.message || 'request failed');
                        return data;
                    });
                })
                .then(function (data) {
                    typing.remove();
                    conversationId = data.conversation_id || conversationId;
                    var reply = data.message || '';
                    addMessage('assistant', reply);
                    history.push({ role: 'assistant', content: reply });
                })
                .catch(function () {
                    typing.remove();
                    addError();
                })
                .finally(function () {
                    setPending(false);
                    if (root.dataset.open === 'true') input.focus();
                });
        }

        function toggle(state) {
            var open = typeof state === 'boolean' ? state : root.dataset.open !== 'true';
            root.dataset.open = open ? 'true' : 'false';
            launcher.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (open) {
                input.focus();
                scroll();
            } else {
                launcher.focus();
            }
        }

        launcher.addEventListener('click', function () {
            toggle();
        });

        if (dismiss) {
            dismiss.addEventListener('click', function () {
                toggle(false);
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && root.dataset.open === 'true') toggle(false);
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submit(input.value, false);
        });

        input.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                submit(input.value, false);
            }
        });

        input.addEventListener('input', function () {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 120) + 'px';
        });

        if (suggestions) {
            suggestions.addEventListener('click', function (event) {
                var button = event.target.closest('[data-uiaikit="suggestion"]');
                if (button) submit(button.textContent.trim(), false);
            });
        }

        if (root.dataset.open === 'true') toggle(true);
    }

    function init() {
        document.querySelectorAll('[data-uiaikit="chat"]').forEach(boot);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
