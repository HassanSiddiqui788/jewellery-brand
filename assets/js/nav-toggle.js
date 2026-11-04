/**
 * Universal Navigation & Hamburger Menu Toggle Handler
 * Handles both mobile dropdown menu and desktop drawer popup
 * Bijoux Jewelry Store
 */
(function() {
    'use strict';

    function initNavToggles() {
        // -------------------------------------------------------------
        // 1. Mobile & Tablet Hamburger Toggle (.elementor-menu-toggle)
        // -------------------------------------------------------------
        document.addEventListener('click', function(e) {
            var toggleBtn = e.target.closest('.elementor-menu-toggle');
            if (toggleBtn) {
                e.preventDefault();
                e.stopPropagation();

                var isActive = toggleBtn.classList.contains('elementor-active');
                var widget = toggleBtn.closest('.elementor-widget-nav-menu') || toggleBtn.parentElement;
                var dropdown = widget ? widget.querySelector('.elementor-nav-menu--dropdown.elementor-nav-menu__container') : null;

                if (!dropdown) {
                    dropdown = toggleBtn.nextElementSibling;
                    if (!dropdown || !dropdown.classList.contains('elementor-nav-menu--dropdown')) {
                        dropdown = document.querySelector('.elementor-element-17024d6 .elementor-nav-menu--dropdown') ||
                                   document.querySelector('.elementor-nav-menu--dropdown.elementor-nav-menu__container');
                    }
                }

                if (isActive) {
                    toggleBtn.classList.remove('elementor-active');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    if (dropdown) {
                        dropdown.classList.remove('elementor-active');
                        dropdown.setAttribute('aria-hidden', 'true');
                    }
                    document.body.classList.remove('vamtam-disable-scroll');
                } else {
                    toggleBtn.classList.add('elementor-active');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    if (dropdown) {
                        dropdown.classList.add('elementor-active');
                        dropdown.setAttribute('aria-hidden', 'false');
                    }
                    document.body.classList.add('vamtam-disable-scroll');
                }
                return;
            }

            // Submenu toggle inside mobile menu
            var subArrow = e.target.closest('.sub-arrow');
            var itemAnchor = e.target.closest('.elementor-nav-menu--dropdown .menu-item-has-children > a');
            if (subArrow || (itemAnchor && (itemAnchor.getAttribute('href') === '#' || itemAnchor.getAttribute('href') === ''))) {
                var menuItem = (subArrow || itemAnchor).closest('.menu-item-has-children');
                if (menuItem) {
                    e.preventDefault();
                    e.stopPropagation();

                    var isSubActive = menuItem.classList.contains('elementor-active');
                    var subMenu = menuItem.querySelector('.sub-menu');

                    if (isSubActive) {
                        menuItem.classList.remove('elementor-active');
                        if (subMenu) {
                            subMenu.classList.remove('sub-menu-open');
                            subMenu.style.display = 'none';
                        }
                    } else {
                        menuItem.classList.add('elementor-active');
                        if (subMenu) {
                            subMenu.classList.add('sub-menu-open');
                            subMenu.style.display = 'block';
                        }
                    }
                    return;
                }
            }

            // Close mobile menu if clicked outside
            var openMobileToggle = document.querySelector('.elementor-menu-toggle.elementor-active');
            if (openMobileToggle && !e.target.closest('.elementor-nav-menu--dropdown') && !e.target.closest('.elementor-menu-toggle')) {
                openMobileToggle.classList.remove('elementor-active');
                openMobileToggle.setAttribute('aria-expanded', 'false');
                var activeDropdowns = document.querySelectorAll('.elementor-nav-menu--dropdown.elementor-active');
                activeDropdowns.forEach(function(d) {
                    d.classList.remove('elementor-active');
                    d.setAttribute('aria-hidden', 'true');
                });
                document.body.classList.remove('vamtam-disable-scroll');
            }
        });

        // -------------------------------------------------------------
        // 2. Desktop Hamburger Side-Menu Drawer & Mega-Menu Popups
        // -------------------------------------------------------------
        function openPopup(modalId) {
            var modal = document.getElementById('elementor-popup-modal-' + modalId);
            if (!modal) return;

            modal.style.display = 'flex';
            void modal.offsetWidth; // Force reflow
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('vamtam-disable-scroll');

            var invisibles = modal.querySelectorAll('.elementor-invisible');
            invisibles.forEach(function(el) {
                el.classList.remove('elementor-invisible');
            });
        }

        function closePopup(modal) {
            if (!modal) return;
            modal.classList.remove('is-active');
            modal.setAttribute('aria-hidden', 'true');
            setTimeout(function() {
                if (!modal.classList.contains('is-active')) {
                    modal.style.display = 'none';
                }
            }, 350);

            var anyActive = document.querySelector('.elementor-popup-modal.is-active');
            if (!anyActive) {
                document.body.classList.remove('vamtam-disable-scroll');
            }
        }

        // Global trigger for desktop side hamburger button & popup links
        document.addEventListener('click', function(e) {
            // Check for side-menu hamburger button or popup trigger
            var sideMenuBtn = e.target.closest('.vamtam-theme-side-menu') ||
                              e.target.closest('.vamtam-popup-toggle') ||
                              e.target.closest('[data-id="03e83c0"]') ||
                              e.target.closest('a[href*="popup%3Aopen"]') ||
                              e.target.closest('a[href*="popup:open"]');

            if (sideMenuBtn) {
                e.preventDefault();
                e.stopPropagation();

                var href = sideMenuBtn.getAttribute('href') || (sideMenuBtn.querySelector('a') ? sideMenuBtn.querySelector('a').getAttribute('href') : '');
                var modalId = '998'; // Default desktop side-drawer menu

                if (href) {
                    var match = href.match(/id%22%3A%22(\d+)%22/) || href.match(/id":\s*"(\d+)"/) || href.match(/id=(\d+)/);
                    if (match && match[1]) {
                        modalId = match[1];
                    }
                }

                var modal = document.getElementById('elementor-popup-modal-' + modalId);
                if (modal && modal.classList.contains('is-active')) {
                    closePopup(modal);
                } else {
                    openPopup(modalId);
                }
                return;
            }

            // Mega-menu "Collections" click
            var megaMenuLink = e.target.closest('.mega-menu a, a.mega-menu');
            if (megaMenuLink) {
                var modal1122 = document.getElementById('elementor-popup-modal-1122');
                if (modal1122) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (modal1122.classList.contains('is-active')) {
                        closePopup(modal1122);
                    } else {
                        openPopup('1122');
                    }
                    return;
                }
            }

            // Popup Close Button Click
            var closeBtn = e.target.closest('.dialog-close-button, .dialog-lightbox-close-button');
            if (closeBtn) {
                e.preventDefault();
                var activeModal = closeBtn.closest('.elementor-popup-modal');
                if (activeModal) {
                    closePopup(activeModal);
                }
                return;
            }

            // Click on Backdrop of Popup (outside content)
            var activeModalOpen = e.target.closest('.elementor-popup-modal.is-active');
            if (activeModalOpen && !e.target.closest('.dialog-widget-content')) {
                closePopup(activeModalOpen);
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                var activePopups = document.querySelectorAll('.elementor-popup-modal.is-active');
                activePopups.forEach(function(modal) {
                    closePopup(modal);
                });

                var activeMobileToggle = document.querySelector('.elementor-menu-toggle.elementor-active');
                if (activeMobileToggle) {
                    activeMobileToggle.classList.remove('elementor-active');
                    activeMobileToggle.setAttribute('aria-expanded', 'false');
                    var activeDropdowns = document.querySelectorAll('.elementor-nav-menu--dropdown.elementor-active');
                    activeDropdowns.forEach(function(d) {
                        d.classList.remove('elementor-active');
                        d.setAttribute('aria-hidden', 'true');
                    });
                    document.body.classList.remove('vamtam-disable-scroll');
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavToggles);
    } else {
        initNavToggles();
    }
})();

