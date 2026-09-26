/* Laravel UI AI Kit — full-page console chatbot.
   No dependencies. Message text is escaped before ```code``` fences are
   turned into <pre> blocks, so nothing except that one tag is ever injected. */

(function () {
    'use strict';

    function boot(root) {
        if (root.dataset.uiaikitcReady === 'true') return;
        root.dataset.uiaikitcReady = 'true';

        var log = root.querySelector('[data-uiaikitc="log"]');
        var form = root.querySelector('[data-uiaikitc="composer"]');
        var input = root.querySelector('[data-uiaikitc="input"]');
        var send = root.querySelector('[data-uiaikitc="send"]');
        var quickActions = root.querySelector('[data-uiaikitc="quick-actions"]');

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

        function timeNow() {
            return new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        }

        function escapeHtml(text) {
            var div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Escapes everything, then turns ```code``` fences into <pre> blocks
        // so replies with commands/snippets render the way the design shows.
        function renderBody(text) {
            var escaped = escapeHtml(text);
            var withBlocks = escaped.replace(/```([\s\S]*?)```/g, function (_, code) {
                return '<pre><code>' + code.replace(/^\n/, '').trim() + '</code></pre>';
            });
            return withBlocks.replace(/\n/g, '<br>');
        }

        function botAvatarSvg() {
            return '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">'
                + '<path d="M7 17.5a4.5 4.5 0 0 1-.6-8.96 5.5 5.5 0 0 1 10.7-1.9A4 4 0 0 1 17 17.5H7Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>';
        }

        function userAvatarSvg() {
            return '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">'
                + '<circle cx="12" cy="8.5" r="3.3" stroke="currentColor" stroke-width="1.7"/>'
                + '<path d="M4.8 19c1.1-3.2 3.9-5 7.2-5s6.1 1.8 7.2 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>';
        }

        function addMessage(role, text) {
            var wrap = document.createElement('div');
            wrap.className = 'uiaikitc-msg uiaikitc-msg--' + role;

            var avatar = document.createElement('span');
            avatar.className = 'uiaikitc-avatar uiaikitc-avatar--' + (role === 'user' ? 'user' : 'bot');
            avatar.innerHTML = role === 'user' ? userAvatarSvg() : botAvatarSvg();

            var body = document.createElement('div');
            body.className = 'uiaikitc-msg__body';

            var bubble = document.createElement('div');
            bubble.className = 'uiaikitc-bubble';
            bubble.innerHTML = renderBody(text);

            var time = document.createElement('span');
            time.className = 'uiaikitc-time';
            time.textContent = timeNow();

            body.appendChild(bubble);
            body.appendChild(time);
            wrap.appendChild(avatar);
            wrap.appendChild(body);
            log.appendChild(wrap);
            scroll();
            return wrap;
        }

        function addTyping() {
            var wrap = document.createElement('div');
            wrap.className = 'uiaikitc-msg uiaikitc-msg--assistant';
            wrap.setAttribute('data-uiaikitc-typing', 'true');

            var avatar = document.createElement('span');
            avatar.className = 'uiaikitc-avatar uiaikitc-avatar--bot';
            avatar.innerHTML = botAvatarSvg();

            var body = document.createElement('div');
            body.className = 'uiaikitc-msg__body';

            var bubble = document.createElement('div');
            bubble.className = 'uiaikitc-bubble';

            var dots = document.createElement('span');
            dots.className = 'uiaikitc-typing';
            dots.appendChild(document.createElement('span'));
            dots.appendChild(document.createElement('span'));
            dots.appendChild(document.createElement('span'));

            var label = document.createElement('span');
            label.className = 'uiaikitc-sr';
            label.textContent = 'LaravelBot is typing';

            bubble.appendChild(dots);
            bubble.appendChild(label);
            body.appendChild(bubble);
            wrap.appendChild(avatar);
            wrap.appendChild(body);
            log.appendChild(wrap);
            scroll();
            return wrap;
        }

        function setPending(state) {
            pending = state;
            send.disabled = state;
            input.disabled = state;
        }

        function submit(text, isRetry) {
            if (pending || !text.trim()) return;

            lastMessage = text;

            if (!isRetry) {
                addMessage('user', text);
                history.push({ role: 'user', content: text });
            }

            input.value = '';
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
                    addMessage('assistant', errorText);
                })
                .finally(function () {
                    setPending(false);
                    input.focus();
                });
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submit(input.value, false);
        });

        if (quickActions) {
            quickActions.addEventListener('click', function (event) {
                var button = event.target.closest('[data-uiaikitc-prompt]');
                if (!button) return;
                var prompt = button.getAttribute('data-uiaikitc-prompt') || '';
                if (prompt) {
                    submit(prompt, false);
                } else {
                    input.focus();
                }
            });
        }

        scroll();
    }

    function init() {
        document.querySelectorAll('[data-uiaikitc="app"]').forEach(boot);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
