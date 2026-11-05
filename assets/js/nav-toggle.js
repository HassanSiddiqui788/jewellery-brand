/**
 * Universal Navigation, Hamburger Menu & Side Cart Handler
 * Handles mobile menu, desktop side-drawer menu, collections mega-menu, and interactive side cart
 * Lorem Ipsum Store
 */
(function() {
    'use strict';

    // =========================================================================
    // 1. Interactive Shopping Cart Engine
    // =========================================================================
    var CART_STORAGE_KEY = 'bijoux_cart_items';

    function getCart() {
        try {
            var raw = localStorage.getItem(CART_STORAGE_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        try {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {}
    }

    function getBasePath() {
        var base = './';
        var script = document.querySelector('script[src*="nav-toggle.js"]');
        if (script) {
            var src = script.getAttribute('src');
            var idx = src.indexOf('assets/');
            if (idx !== -1) {
                base = src.substring(0, idx);
            }
        }
        return base;
    }

    function formatPrice(num) {
        return '$' + parseFloat(num).toFixed(2);
    }

    function renderCart() {
        var cart = getCart();
        var totalQty = 0;
        var subtotal = 0;

        cart.forEach(function(item) {
            totalQty += (item.qty || 1);
            subtotal += (parseFloat(item.priceNum) || 0) * (item.qty || 1);
        });

        // Update badge counters across header
        var qtyBadges = document.querySelectorAll('.elementor-button-icon-qty');
        qtyBadges.forEach(function(badge) {
            badge.textContent = totalQty;
            badge.setAttribute('data-counter', totalQty);
        });

        // Update cart header item counts
        var headerItemCounts = document.querySelectorAll('.vamtam-elementor-menu-cart__header .item-count');
        headerItemCounts.forEach(function(countEl) {
            countEl.textContent = '(' + totalQty + ')';
        });

        // Update toggle button prices
        var priceElements = document.querySelectorAll('.elementor-menu-cart__toggle .woocommerce-Price-amount amount bdi, .elementor-menu-cart__toggle .woocommerce-Price-amount');
        priceElements.forEach(function(el) {
            el.innerHTML = '<span class="woocommerce-Price-currencySymbol" translate="no">&#36;</span>' + subtotal.toFixed(2);
        });

        // Update cart drawers content
        var cartContainers = document.querySelectorAll('.widget_shopping_cart_content');
        var base = getBasePath();

        cartContainers.forEach(function(container) {
            if (cart.length === 0) {
                container.innerHTML = 
                    '<div class="site-mini-cart-empty">' +
                        '<svg class="site-mini-cart-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>' +
                            '<line x1="3" y1="6" x2="21" y2="6"></line>' +
                            '<path d="M16 10a4 4 0 0 1-8 0"></path>' +
                        '</svg>' +
                        '<h3 class="site-mini-cart-empty-title">Your Cart is Empty</h3>' +
                        '<p class="site-mini-cart-empty-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor.</p>' +
                        '<a href="' + base + 'shop/collections/index.php" class="site-mini-cart-btn">Explore Collections</a>' +
                    '</div>';
            } else {
                var itemsHtml = '<ul class="site-mini-cart-items">';
                cart.forEach(function(item, idx) {
                    var itemSub = (parseFloat(item.priceNum) || 0) * (item.qty || 1);
                    itemsHtml += 
                        '<li class="site-mini-cart-item">' +
                            (item.img ? '<img src="' + item.img + '" alt="' + (item.title || '') + '" class="site-mini-cart-item-img">' : '') +
                            '<div class="site-mini-cart-item-info">' +
                                '<a href="' + (item.url || '#') + '" class="site-mini-cart-item-title">' + (item.title || 'Product') + '</a>' +
                                '<div class="site-mini-cart-item-meta">' +
                                    '<span class="site-mini-cart-item-qty">' + item.qty + ' &times;</span>' +
                                    '<span class="site-mini-cart-item-price">' + formatPrice(item.priceNum) + '</span>' +
                                '</div>' +
                            '</div>' +
                            '<button type="button" class="site-mini-cart-item-remove" data-cart-index="' + idx + '" aria-label="Remove item">&times;</button>' +
                        '</li>';
                });
                itemsHtml += '</ul>';

                var footerHtml = 
                    '<div class="site-mini-cart-footer">' +
                        '<div class="site-mini-cart-subtotal">' +
                            '<span>Subtotal:</span>' +
                            '<span class="site-mini-cart-subtotal-val">' + formatPrice(subtotal) + '</span>' +
                        '</div>' +
                        '<div class="site-mini-cart-actions">' +
                            '<a href="' + base + 'shop/cart.php" class="btn-view-cart">View Cart</a>' +
                            '<a href="' + base + 'shop/checkout.php" class="btn-checkout">Checkout</a>' +
                        '</div>' +
                    '</div>';

                container.innerHTML = itemsHtml + footerHtml;
            }
        });
    }

    function openCartDrawer() {
        var cartContainers = document.querySelectorAll('.elementor-menu-cart__container');
        var cartWidgets = document.querySelectorAll('.elementor-widget-woocommerce-menu-cart');

        cartContainers.forEach(function(el) {
            el.classList.add('elementor-menu-cart--shown', 'is-active');
            el.setAttribute('aria-hidden', 'false');
        });

        cartWidgets.forEach(function(el) {
            el.classList.add('elementor-menu-cart--shown');
        });

        document.body.classList.add('vamtam-disable-scroll');
        renderCart();
    }

    function closeCartDrawer() {
        var cartContainers = document.querySelectorAll('.elementor-menu-cart__container');
        var cartWidgets = document.querySelectorAll('.elementor-widget-woocommerce-menu-cart');

        cartContainers.forEach(function(el) {
            el.classList.remove('elementor-menu-cart--shown', 'is-active');
            el.setAttribute('aria-hidden', 'true');
        });

        cartWidgets.forEach(function(el) {
            el.classList.remove('elementor-menu-cart--shown');
        });

        checkScrollLock();
    }

    function isCartOpen() {
        return !!document.querySelector('.elementor-menu-cart__container.elementor-menu-cart--shown, .elementor-menu-cart__container.is-active');
    }

    // =========================================================================
    // 2. Desktop Modal / Popup Engine (Popups 998 & 1122)
    // =========================================================================
    function openPopup(modalId) {
        var modal = document.getElementById('elementor-popup-modal-' + modalId);
        if (!modal) return;

        // Close cart if open
        closeCartDrawer();

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

        checkScrollLock();
    }

    function checkScrollLock() {
        var anyPopupActive = document.querySelector('.elementor-popup-modal.is-active');
        var anyCartActive = document.querySelector('.elementor-menu-cart__container.elementor-menu-cart--shown, .elementor-menu-cart__container.is-active');
        var anyMobileActive = document.querySelector('.elementor-menu-toggle.elementor-active');

        if (!anyPopupActive && !anyCartActive && !anyMobileActive) {
            document.body.classList.remove('vamtam-disable-scroll');
        }
    }

    // =========================================================================
    // 3. Main Event Handlers
    // =========================================================================
    function initNavToggles() {
        // Initial cart render on load
        renderCart();

        document.addEventListener('click', function(e) {
            // -----------------------------------------------------------------
            // A. Shopping Bag / Add to Cart Header Button Click
            // -----------------------------------------------------------------
            var cartToggle = e.target.closest('#elementor-menu-cart__toggle_button') ||
                             e.target.closest('.elementor-menu-cart__toggle_button') ||
                             e.target.closest('.elementor-menu-cart__toggle') ||
                             e.target.closest('.e-toggle-cart-custom-icon');

            if (cartToggle) {
                e.preventDefault();
                e.stopPropagation();

                if (isCartOpen()) {
                    closeCartDrawer();
                } else {
                    openCartDrawer();
                }
                return;
            }

            // Close Cart Button
            var cartCloseBtn = e.target.closest('.elementor-menu-cart__close-button') ||
                               e.target.closest('.vamtam-close-cart');
            if (cartCloseBtn) {
                e.preventDefault();
                e.stopPropagation();
                closeCartDrawer();
                return;
            }

            // Click outside Cart Panel (on backdrop)
            if (isCartOpen()) {
                var cartContainer = e.target.closest('.elementor-menu-cart__container');
                var cartMain = e.target.closest('.elementor-menu-cart__main');
                if (cartContainer && !cartMain) {
                    e.preventDefault();
                    closeCartDrawer();
                    return;
                }
            }

            // Remove item from mini cart
            var removeBtn = e.target.closest('.site-mini-cart-item-remove');
            if (removeBtn) {
                e.preventDefault();
                e.stopPropagation();
                var idx = parseInt(removeBtn.getAttribute('data-cart-index'), 10);
                var cart = getCart();
                if (!isNaN(idx) && idx >= 0 && idx < cart.length) {
                    cart.splice(idx, 1);
                    saveCart(cart);
                    renderCart();
                }
                return;
            }

            // -----------------------------------------------------------------
            // B. Add to Cart Button Click on Product Page / Loops
            // -----------------------------------------------------------------
            var addToCartBtn = e.target.closest('.single_add_to_cart_button') ||
                               e.target.closest('button[name="add-to-cart"]') ||
                               e.target.closest('.add_to_cart_button');

            if (addToCartBtn) {
                e.preventDefault();
                e.stopPropagation();

                // Extract product info
                var productContainer = addToCartBtn.closest('.product') ||
                                       addToCartBtn.closest('article') ||
                                       document.querySelector('.product') ||
                                       document.body;

                var titleEl = productContainer.querySelector('.product_title') ||
                              productContainer.querySelector('.elementor-heading-title') ||
                              productContainer.querySelector('h1') ||
                              productContainer.querySelector('.woocommerce-loop-product__title');
                var title = titleEl ? titleEl.textContent.trim() : 'Artisan Jewelry Piece';

                var priceEl = productContainer.querySelector('.price .woocommerce-Price-amount') ||
                              productContainer.querySelector('.price') ||
                              productContainer.querySelector('.amount');
                var priceText = priceEl ? priceEl.textContent.trim() : '$120.00';
                var cleanPrice = priceText.replace(/[^0-9.]/g, '');
                var priceNum = parseFloat(cleanPrice) || 120.00;

                var imgEl = productContainer.querySelector('.woocommerce-product-gallery__image img') ||
                            productContainer.querySelector('.attachment-woocommerce_thumbnail') ||
                            productContainer.querySelector('.wp-post-image') ||
                            productContainer.querySelector('img[src*="assets/images"]');
                var img = imgEl ? (imgEl.getAttribute('data-lazy-src') || imgEl.getAttribute('src')) : '';

                var qtyInput = productContainer.querySelector('input.qty');
                var qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;

                var id = addToCartBtn.getAttribute('value') || title.toLowerCase().replace(/[^a-z0-9]/g, '-');

                var currentCart = getCart();
                var existingIndex = -1;
                for (var i = 0; i < currentCart.length; i++) {
                    if (currentCart[i].id === id || currentCart[i].title === title) {
                        existingIndex = i;
                        break;
                    }
                }

                if (existingIndex > -1) {
                    currentCart[existingIndex].qty = (currentCart[existingIndex].qty || 1) + qty;
                } else {
                    currentCart.push({
                        id: id,
                        title: title,
                        priceNum: priceNum,
                        img: img,
                        qty: qty,
                        url: window.location.href
                    });
                }

                saveCart(currentCart);
                renderCart();
                openCartDrawer();
                return;
            }

            // -----------------------------------------------------------------
            // C. Desktop Hamburger Side-Menu Toggle Button (Popup 998)
            // -----------------------------------------------------------------
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

            // -----------------------------------------------------------------
            // D. Mega-Menu "Collections" Toggle (Popup 1122)
            // -----------------------------------------------------------------
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

            // -----------------------------------------------------------------
            // E. Close Popup Modal Button
            // -----------------------------------------------------------------
            var closePopupBtn = e.target.closest('.dialog-close-button, .dialog-lightbox-close-button');
            if (closePopupBtn) {
                e.preventDefault();
                var activeModal = closePopupBtn.closest('.elementor-popup-modal');
                if (activeModal) {
                    closePopup(activeModal);
                }
                return;
            }

            // Click outside Modal Content (on backdrop)
            var activeModalOpen = e.target.closest('.elementor-popup-modal.is-active');
            if (activeModalOpen && !e.target.closest('.dialog-widget-content')) {
                closePopup(activeModalOpen);
                return;
            }

            // -----------------------------------------------------------------
            // F. Mobile & Tablet Hamburger Menu Toggle (.elementor-menu-toggle)
            // -----------------------------------------------------------------
            var toggleBtn = e.target.closest('.elementor-menu-toggle');
            if (toggleBtn) {
                e.preventDefault();
                e.stopPropagation();

                var isActive = toggleBtn.classList.contains('elementor-active');
                var header = toggleBtn.closest('.site-header') || toggleBtn.closest('.elementor-widget-nav-menu') || toggleBtn.parentElement;
                var dropdown = header ? header.querySelector('.elementor-nav-menu--dropdown.elementor-nav-menu__container') : null;

                if (!dropdown) {
                    dropdown = document.querySelector('.elementor-nav-menu--dropdown.elementor-nav-menu__container') ||
                               document.querySelector('.elementor-nav-menu--dropdown');
                }

                if (isActive) {
                    toggleBtn.classList.remove('elementor-active');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                    if (dropdown) {
                        dropdown.classList.remove('elementor-active');
                        dropdown.setAttribute('aria-hidden', 'true');
                    }
                } else {
                    toggleBtn.classList.add('elementor-active');
                    toggleBtn.setAttribute('aria-expanded', 'true');
                    if (dropdown) {
                        dropdown.classList.add('elementor-active');
                        dropdown.setAttribute('aria-hidden', 'false');
                    }
                }
                checkScrollLock();
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
                checkScrollLock();
            }
        });

        // -----------------------------------------------------------------
        // G. Close on ESC Key
        // -----------------------------------------------------------------
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' || e.keyCode === 27) {
                // Close Cart
                if (isCartOpen()) {
                    closeCartDrawer();
                }

                // Close Popups
                var activePopups = document.querySelectorAll('.elementor-popup-modal.is-active');
                activePopups.forEach(function(modal) {
                    closePopup(modal);
                });

                // Close Mobile Menu
                var activeMobileToggle = document.querySelector('.elementor-menu-toggle.elementor-active');
                if (activeMobileToggle) {
                    activeMobileToggle.classList.remove('elementor-active');
                    activeMobileToggle.setAttribute('aria-expanded', 'false');
                    var activeDropdowns = document.querySelectorAll('.elementor-nav-menu--dropdown.elementor-active');
                    activeDropdowns.forEach(function(d) {
                        d.classList.remove('elementor-active');
                        d.setAttribute('aria-hidden', 'true');
                    });
                }

                checkScrollLock();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initNavToggles);
    } else {
        initNavToggles();
    }
})();
