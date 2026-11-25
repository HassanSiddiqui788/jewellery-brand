/**
 * Universal Text Copy & Toast Notification Engine
 * Jarwaya Jewels
 *
 * Ensures clean text selection and copying across all devices (Desktop & Mobile)
 * and provides a visible "Copied Successfully!" notification toast.
 */
(function() {
    'use strict';

    var toastElement = null;
    var hideTimeout = null;

    // Self-contained styles to guarantee rendering on all pages
    function ensureStyles() {
        if (document.getElementById('jarwaya-copy-toast-styles')) return;
        var style = document.createElement('style');
        style.id = 'jarwaya-copy-toast-styles';
        style.textContent = [
            '.jarwaya-copy-toast {',
            '  position: fixed;',
            '  bottom: 28px;',
            '  right: 28px;',
            '  background: #051F34;',
            '  color: #FFFFFF;',
            '  font-family: "Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;',
            '  font-size: 13.5px;',
            '  font-weight: 500;',
            '  letter-spacing: 0.5px;',
            '  padding: 11px 20px;',
            '  border-radius: 28px;',
            '  border: 1px solid rgba(203, 146, 116, 0.7);',
            '  box-shadow: 0 10px 30px rgba(5, 31, 52, 0.3), 0 2px 8px rgba(0, 0, 0, 0.15);',
            '  display: inline-flex;',
            '  align-items: center;',
            '  gap: 9px;',
            '  z-index: 2147483647 !important;',
            '  pointer-events: none;',
            '  opacity: 0;',
            '  transform: translateY(16px) scale(0.96);',
            '  transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);',
            '}',
            '.jarwaya-copy-toast.is-visible {',
            '  opacity: 1;',
            '  transform: translateY(0) scale(1);',
            '}',
            '.jarwaya-copy-toast-icon {',
            '  width: 18px;',
            '  height: 18px;',
            '  border-radius: 50%;',
            '  background: #CB9274;',
            '  color: #FFFFFF;',
            '  display: inline-flex;',
            '  align-items: center;',
            '  justify-content: center;',
            '  font-size: 11px;',
            '  font-weight: bold;',
            '  line-height: 1;',
            '  flex-shrink: 0;',
            '}',
            '@media (max-width: 600px) {',
            '  .jarwaya-copy-toast {',
            '    bottom: 20px;',
            '    right: 50%;',
            '    transform: translate(50%, 16px) scale(0.96);',
            '    font-size: 12.5px;',
            '    padding: 9px 16px;',
            '    white-space: nowrap;',
            '  }',
            '  .jarwaya-copy-toast.is-visible {',
            '    transform: translate(50%, 0) scale(1);',
            '  }',
            '}'
        ].join('\n');
        document.head.appendChild(style);
    }

    function createToast() {
        if (toastElement && document.body.contains(toastElement)) return toastElement;

        ensureStyles();
        toastElement = document.createElement('div');
        toastElement.className = 'jarwaya-copy-toast';
        toastElement.setAttribute('role', 'status');
        toastElement.setAttribute('aria-live', 'polite');

        var icon = document.createElement('span');
        icon.className = 'jarwaya-copy-toast-icon';
        icon.innerHTML = '&#10003;';

        var text = document.createElement('span');
        text.className = 'jarwaya-copy-toast-text';
        text.textContent = 'Copied Successfully!';

        toastElement.appendChild(icon);
        toastElement.appendChild(text);
        document.body.appendChild(toastElement);

        return toastElement;
    }

    function showToast() {
        var toast = createToast();
        if (!toast) return;

        if (hideTimeout) {
            clearTimeout(hideTimeout);
            hideTimeout = null;
        }

        // Force reflow
        void toast.offsetWidth;
        toast.classList.add('is-visible');

        hideTimeout = setTimeout(function() {
            toast.classList.remove('is-visible');
        }, 2200);
    }

    // 1. Listen for standard copy event (fires on keyboard shortcuts, right click copy, and mobile copy)
    document.addEventListener('copy', function(e) {
        showToast();
    });

    // 2. Expose globally
    window.showJarwayaCopySuccess = showToast;
})();
