/* Laravel UI AI Kit — landing page behaviour. Copy-to-clipboard and smooth anchors. */

(function () {
    'use strict';

    function init() {
        document.querySelectorAll('[data-uiaikit-copy]').forEach(function (button) {
            button.addEventListener('click', function () {
                var value = button.getAttribute('data-uiaikit-copy') || '';
                var done = function () {
                    var original = button.textContent;
                    button.textContent = 'Copied';
                    setTimeout(function () {
                        button.textContent = original;
                    }, 1600);
                };

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(value).then(done);
                    return;
                }

                var field = document.createElement('textarea');
                field.value = value;
                field.setAttribute('readonly', '');
                field.style.position = 'absolute';
                field.style.left = '-9999px';
                document.body.appendChild(field);
                field.select();
                try {
                    document.execCommand('copy');
                    done();
                } finally {
                    field.remove();
                }
            });
        });

        document.querySelectorAll('.uiaikit a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (event) {
                var target = document.querySelector(anchor.getAttribute('href'));
                if (!target) return;
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                target.setAttribute('tabindex', '-1');
                target.focus({ preventScroll: true });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
