/* Full-page Laravel chat interface. Conversation records stay in this browser. */

(function () {
    'use strict';

    function init() {
        var app = document.querySelector('[data-chat-app]');
        if (!app) return;

        var sidebar = document.querySelector('[data-sidebar]');
        var historyNav = document.querySelector('[data-history]');
        var historyEmpty = document.querySelector('[data-history-empty]');
        var search = document.querySelector('[data-search-history]');
        var emptyState = document.querySelector('[data-empty-state]');
        var promptList = document.querySelector('[data-prompts]');
        var messagesView = document.querySelector('[data-messages]');
        var form = document.querySelector('[data-composer]');
        var input = document.querySelector('[data-input]');
        var send = document.querySelector('[data-send]');
        var storageKey = app.getAttribute('data-storage-key') + ':' + window.location.pathname;
        var apiEndpoint = app.getAttribute('data-endpoint');
        var errorMessage = app.getAttribute('data-error') || 'The request could not be completed.';
        var assistantName = app.getAttribute('data-assistant') || 'Laravel Assistant';
        var assistantMark = app.getAttribute('data-assistant-mark') || '';
        var assistantMonogram = app.getAttribute('data-assistant-monogram') || 'L';
        var historyLimit = Math.max(1, parseInt(app.getAttribute('data-history-limit'), 10) || 30);
        var conversations = [];
        var activeId = null;
        var pending = false;
        var lastMessage = '';

        function loadConversations() {
            try {
                var stored = JSON.parse(window.localStorage.getItem(storageKey) || '[]');
                if (!Array.isArray(stored)) return [];
                return stored.filter(function (conversation) {
                    return conversation && typeof conversation.id === 'string' && Array.isArray(conversation.messages);
                }).slice(0, historyLimit);
            } catch (error) {
                return [];
            }
        }

        function saveConversations() {
            try {
                conversations = conversations.slice(0, historyLimit);
                window.localStorage.setItem(storageKey, JSON.stringify(conversations));
            } catch (error) {
                // The current conversation continues in memory if storage is unavailable.
            }
        }

        function activeConversation() {
            return conversations.find(function (conversation) { return conversation.id === activeId; }) || null;
        }

        function scrollToLatest() {
            var thread = document.querySelector('.uiaikit-chat-thread');
            thread.scrollTop = thread.scrollHeight;
        }

        function renderMessageText(element, text) {
            String(text).split(/(`[^`]+`)/g).forEach(function (part) {
                if (part.length > 1 && part.charAt(0) === '`' && part.charAt(part.length - 1) === '`') {
                    var code = document.createElement('code');
                    code.textContent = part.slice(1, -1);
                    element.appendChild(code);
                    return;
                }

                element.appendChild(document.createTextNode(part));
            });
        }

        function appendMessage(role, content, extraClass) {
            var row = document.createElement('article');
            row.className = 'uiaikit-chat-message uiaikit-chat-message--' + role + (extraClass ? ' uiaikit-chat-message--' + extraClass : '');

            var avatar = document.createElement('span');
            avatar.className = 'uiaikit-chat-message__avatar';
            avatar.setAttribute('aria-hidden', 'true');
            if (role === 'user') {
                avatar.textContent = 'Y';
            } else if (assistantMark) {
                var avatarImage = document.createElement('img');
                avatarImage.src = assistantMark;
                avatarImage.alt = '';
                avatar.appendChild(avatarImage);
            } else {
                avatar.textContent = assistantMonogram;
            }

            var contentWrap = document.createElement('div');
            contentWrap.className = 'uiaikit-chat-message__content';

            var roleLabel = document.createElement('span');
            roleLabel.className = 'uiaikit-chat-message__role';
            roleLabel.textContent = role === 'user' ? 'You' : assistantName;

            var body = document.createElement('div');
            body.className = 'uiaikit-chat-message__body';
            renderMessageText(body, content);

            contentWrap.appendChild(roleLabel);
            contentWrap.appendChild(body);
            row.appendChild(avatar);
            row.appendChild(contentWrap);
            messagesView.appendChild(row);
            return row;
        }

        function renderHistory() {
            var query = (search.value || '').trim().toLowerCase();
            var visible = conversations.filter(function (conversation) {
                return !query || (conversation.title || '').toLowerCase().includes(query);
            });

            historyNav.replaceChildren();
            visible.forEach(function (conversation) {
                var row = document.createElement('div');
                row.className = 'uiaikit-chat-history__row' + (conversation.id === activeId ? ' is-active' : '');

                var select = document.createElement('button');
                select.type = 'button';
                select.className = 'uiaikit-chat-history__item';
                select.textContent = conversation.title || 'New conversation';
                select.title = select.textContent;
                select.addEventListener('click', function () {
                    activeId = conversation.id;
                    renderConversation();
                    closeSidebar();
                });

                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'uiaikit-chat-history__delete';
                remove.setAttribute('aria-label', 'Delete conversation');
                remove.title = 'Delete conversation';
                remove.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3m3 0-.8 13H6.8L6 7m4 4v5m4-5v5"/></svg>';
                remove.addEventListener('click', function () {
                    conversations = conversations.filter(function (item) { return item.id !== conversation.id; });
                    if (activeId === conversation.id) activeId = conversations[0]?.id || null;
                    saveConversations();
                    renderConversation();
                });

                row.appendChild(select);
                row.appendChild(remove);
                historyNav.appendChild(row);
            });

            historyEmpty.hidden = conversations.length > 0 && (visible.length > 0 || query.length > 0);
            if (conversations.length > 0 && visible.length === 0 && query) {
                historyEmpty.textContent = 'No matching chats.';
                historyEmpty.hidden = false;
            } else if (conversations.length === 0) {
                historyEmpty.textContent = 'Your conversations will appear here.';
                historyEmpty.hidden = false;
            }
        }

        function renderConversation() {
            var conversation = activeConversation();
            messagesView.replaceChildren();
            var hasMessages = !!(conversation && conversation.messages.length);
            messagesView.classList.toggle('has-messages', hasMessages);
            emptyState.hidden = hasMessages;
            document.body.classList.toggle('has-conversation', hasMessages);

            if (conversation) {
                conversation.messages.forEach(function (message) {
                    if (message.role === 'error') {
                        var errorRow = appendMessage('assistant', message.content, 'error');
                        var retry = document.createElement('button');
                        retry.type = 'button';
                        retry.className = 'uiaikit-chat-message__retry';
                        retry.textContent = 'Try again';
                        retry.addEventListener('click', function () { submit(message.failedMessage || lastMessage, true); });
                        errorRow.querySelector('.uiaikit-chat-message__content').appendChild(retry);
                    } else {
                        appendMessage(message.role, message.content);
                    }
                });
            }

            renderHistory();
            scrollToLatest();
        }

        function makeId() {
            if (window.crypto && typeof window.crypto.randomUUID === 'function') return window.crypto.randomUUID();
            return 'chat-' + Date.now() + '-' + Math.random().toString(16).slice(2);
        }

        function showTyping() {
            var typing = appendMessage('assistant', '', 'typing');
            var body = typing.querySelector('.uiaikit-chat-message__body');
            var skeleton = document.createElement('span');
            skeleton.className = 'uiaikit-chat-skeleton';
            skeleton.setAttribute('aria-hidden', 'true');

            for (var line = 0; line < 3; line += 1) {
                var skeletonLine = document.createElement('span');
                skeletonLine.className = 'uiaikit-chat-skeleton__line';
                skeleton.appendChild(skeletonLine);
            }

            var label = document.createElement('span');
            label.className = 'uiaikit-sr';
            label.textContent = assistantName + ' is thinking';

            body.setAttribute('role', 'status');
            body.replaceChildren(skeleton, label);
            scrollToLatest();

            return typing;
        }

        function submit(text, retry, localAnswer) {
            text = (text || '').trim();
            if (!text || pending) return;

            var conversation = activeConversation();
            if (!conversation) {
                conversation = { id: makeId(), title: text.slice(0, 54), updatedAt: Date.now(), messages: [] };
                conversations.unshift(conversation);
                activeId = conversation.id;
                emptyState.hidden = true;
                messagesView.classList.add('has-messages');
                document.body.classList.add('has-conversation');
            }

            lastMessage = text;
            if (!retry) {
                conversation.messages.push({ role: 'user', content: text });
                appendMessage('user', text);
                input.value = '';
                input.style.height = 'auto';
            }
            conversation.updatedAt = Date.now();
            saveConversations();
            renderHistory();

            if (!retry && localAnswer) {
                conversation.messages.push({ role: 'assistant', content: localAnswer });
                saveConversations();
                appendMessage('assistant', localAnswer);
                renderHistory();
                scrollToLatest();
                return;
            }

            pending = true;
            send.disabled = true;
            var typing = showTyping();
            var csrfMeta = document.querySelector('meta[name="csrf-token"]');
            var headers = { 'Content-Type': 'application/json', Accept: 'application/json' };
            if (csrfMeta) headers['X-CSRF-TOKEN'] = csrfMeta.content;

            fetch(apiEndpoint, {
                method: 'POST',
                headers: headers,
                credentials: 'same-origin',
                body: JSON.stringify({
                    message: text,
                    conversation_id: conversation.id,
                    history: conversation.messages.filter(function (message) {
                        return message.role === 'user' || message.role === 'assistant';
                    }).slice(-50),
                }),
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) throw new Error(data.message || errorMessage);
                        return data;
                    });
                })
                .then(function (data) {
                    typing.remove();
                    var reply = data.message || '';
                    conversation.messages.push({ role: 'assistant', content: reply });
                    if (data.conversation_id && data.conversation_id !== conversation.id) {
                        var previousId = conversation.id;
                        conversation.id = data.conversation_id;
                        activeId = activeId === previousId ? conversation.id : activeId;
                    }
                    conversation.updatedAt = Date.now();
                    saveConversations();
                    appendMessage('assistant', reply);
                    renderHistory();
                })
                .catch(function () {
                    typing.remove();
                    conversation.messages.push({ role: 'error', content: errorMessage, failedMessage: text });
                    saveConversations();
                    var errorRow = appendMessage('assistant', errorMessage, 'error');
                    var retryButton = document.createElement('button');
                    retryButton.type = 'button';
                    retryButton.className = 'uiaikit-chat-message__retry';
                    retryButton.textContent = 'Try again';
                    retryButton.addEventListener('click', function () { submit(text, true); });
                    errorRow.querySelector('.uiaikit-chat-message__content').appendChild(retryButton);
                })
                .finally(function () {
                    pending = false;
                    send.disabled = false;
                    input.focus();
                    scrollToLatest();
                });
        }

        function newChat() {
            activeId = null;
            input.value = '';
            input.style.height = 'auto';
            document.body.classList.remove('has-conversation');
            renderConversation();
            input.focus();
            closeSidebar();
        }

        function closeSidebar() {
            document.body.classList.remove('sidebar-open');
        }

        document.querySelector('[data-new-chat]').addEventListener('click', newChat);
        document.querySelector('[data-open-sidebar]').addEventListener('click', function () {
            document.body.classList.add('sidebar-open');
        });
        document.querySelector('[data-close-sidebar]').addEventListener('click', closeSidebar);
        search.addEventListener('input', renderHistory);

        promptList.addEventListener('click', function (event) {
            var button = event.target.closest('[data-prompt]');
            if (!button) return;

            var localAnswer = app.getAttribute('data-driver') === 'echo'
                ? button.getAttribute('data-answer')
                : null;
            submit(button.getAttribute('data-prompt'), false, localAnswer);
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
            input.style.height = Math.min(input.scrollHeight, 170) + 'px';
        });

        document.addEventListener('keydown', function (event) {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'k') {
                event.preventDefault();
                newChat();
            }
            if (event.key === 'Escape') closeSidebar();
        });

        var themeButton = document.querySelector('[data-theme-toggle]');
        var storedTheme;
        try { storedTheme = window.localStorage.getItem('ui-ai-kit-theme'); } catch (error) { storedTheme = null; }
        if (storedTheme === 'light' || storedTheme === 'dark') document.body.setAttribute('data-uiaikit-theme', storedTheme);
        themeButton.setAttribute('aria-label', document.body.dataset.uiaikitTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        themeButton.addEventListener('click', function () {
            var nextTheme = document.body.dataset.uiaikitTheme === 'dark' ? 'light' : 'dark';
            document.body.setAttribute('data-uiaikit-theme', nextTheme);
            themeButton.setAttribute('aria-label', nextTheme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
            try { window.localStorage.setItem('ui-ai-kit-theme', nextTheme); } catch (error) { /* Theme still changes for this view. */ }
        });

        conversations = loadConversations();
        activeId = conversations[0]?.id || null;
        renderConversation();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
