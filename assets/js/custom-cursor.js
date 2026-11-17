/**
 * Luxury Interactive Cursor
 * Smooth following outer ring + center dot with magnetic hover states
 */
(function() {
    'use strict';

    // Disable on touch-only devices
    if (window.matchMedia && window.matchMedia('(hover: none) and (pointer: coarse)').matches) {
        return;
    }

    function initCustomCursor() {
        if (document.querySelector('.custom-cursor-dot')) {
            return;
        }

        const cursorDot = document.createElement('div');
        cursorDot.className = 'custom-cursor-dot';

        const cursorRing = document.createElement('div');
        cursorRing.className = 'custom-cursor-ring';

        document.body.appendChild(cursorDot);
        document.body.appendChild(cursorRing);

        let mouseX = -100;
        let mouseY = -100;
        let ringX = -100;
        let ringY = -100;
        let isVisible = false;

        window.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;

            if (!isVisible) {
                isVisible = true;
                document.body.classList.add('has-custom-cursor');
                cursorDot.style.opacity = '1';
                cursorRing.style.opacity = '1';
                ringX = mouseX;
                ringY = mouseY;
            }

            cursorDot.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0)';
        }, { passive: true });

        document.addEventListener('mouseleave', function() {
            isVisible = false;
            cursorDot.style.opacity = '0';
            cursorRing.style.opacity = '0';
        });

        document.addEventListener('mouseenter', function() {
            isVisible = true;
            cursorDot.style.opacity = '1';
            cursorRing.style.opacity = '1';
        });

        // 60fps smooth Lerp interpolation for outer ring
        function loop() {
            if (isVisible) {
                ringX += (mouseX - ringX) * 0.16;
                ringY += (mouseY - ringY) * 0.16;
                cursorRing.style.transform = 'translate3d(' + ringX + 'px, ' + ringY + 'px, 0)';
            }
            requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);

        // Interactive hover targets
        const hoverSelector = 'a, button, [role="button"], input[type="submit"], input[type="button"], select, .home-product-card, .category-card, .promo-banner-card, .home-testimonial-card, .site-nav-link, .editorial-btn, .home-story-btn, .home-trends-btn';

        document.addEventListener('mouseover', function(e) {
            if (!e.target || !e.target.closest) return;

            // Handle text input fields - hide custom cursor so native text cursor displays
            if (e.target.closest('input[type="text"], input[type="email"], input[type="password"], textarea')) {
                cursorRing.style.opacity = '0';
                cursorDot.style.opacity = '0';
                return;
            }

            if (e.target.closest(hoverSelector)) {
                cursorRing.classList.add('cursor-hover');
                cursorDot.classList.add('cursor-hover');
            }
        });

        document.addEventListener('mouseout', function(e) {
            if (!e.target || !e.target.closest) return;

            if (e.target.closest('input[type="text"], input[type="email"], input[type="password"], textarea')) {
                if (isVisible) {
                    cursorRing.style.opacity = '1';
                    cursorDot.style.opacity = '1';
                }
            }

            if (e.target.closest(hoverSelector)) {
                cursorRing.classList.remove('cursor-hover');
                cursorDot.classList.remove('cursor-hover');
            }
        });

        document.addEventListener('mousedown', function() {
            cursorRing.classList.add('cursor-active');
        });

        document.addEventListener('mouseup', function() {
            cursorRing.classList.remove('cursor-active');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCustomCursor);
    } else {
        initCustomCursor();
    }
})();
