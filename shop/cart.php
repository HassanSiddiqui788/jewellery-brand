<?php
/**
 * Page: Shopping Cart – Lorem Ipsum
 * Interactive luxury shopping bag with quantity controls, line totals,
 * and direct checkout routing.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/config.php';

$base_path = '../';
$page_title = 'Shopping Bag – JARWAYA JEWELS';
$body_class = 'page page-cart';
$current_page = 'cart';
$page_css = ['checkout.css'];

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="checkout-page-container">
    <header class="checkout-hero-banner">
        <nav class="checkout-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= $base_path ?>index.php">Home</a>
            <span class="sep">/</span>
            <span aria-current="page">Shopping Bag</span>
        </nav>
        <h1 class="checkout-title">Your Shopping Bag</h1>
        <p class="checkout-subtitle">Review your selected artisan jewelry pieces before proceeding to checkout.</p>
    </header>

    <div id="full-cart-content-wrapper">
        <!-- Live cart table or empty state rendered via JavaScript -->
        <div class="checkout-empty-state">
            <svg class="checkout-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
            <h2 class="checkout-empty-title">Your Shopping Bag is Empty</h2>
            <p class="checkout-empty-desc">You do not have any items in your bag yet. Explore our handcrafted collections of necklaces, bracelets, and earrings.</p>
            <a href="<?= $base_path ?>shop/collections/index.php" class="btn-browse-collections">
                <i class="fas fa-gem" aria-hidden="true"></i> Explore Collections
            </a>
        </div>
    </div>
</main>

<script>
(function() {
    'use strict';

    const CART_KEY = 'bijoux_cart_items';
    const container = document.getElementById('full-cart-content-wrapper');

    function getCart() {
        try {
            const raw = localStorage.getItem(CART_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    function saveCart(cart) {
        try {
            localStorage.setItem(CART_KEY, JSON.stringify(cart));
            // Trigger storage event for cross-tab or header badge updates
            window.dispatchEvent(new Event('storage'));
            updateHeaderBadges(cart);
        } catch (e) {}
    }

    function updateHeaderBadges(cart) {
        let total = 0;
        cart.forEach(item => {
            total += (parseInt(item.qty, 10) || 1);
        });
        document.querySelectorAll('.elementor-button-icon-qty').forEach(b => {
            b.textContent = total;
            b.setAttribute('data-counter', total);
        });
    }

    function formatPrice(num) {
        var val = parseFloat(num) || 0;
        return 'Rs. ' + Math.round(val).toLocaleString('en-US');
    }

    function renderFullCart() {
        const cart = getCart();

        if (!cart || cart.length === 0) {
            container.innerHTML = `
                <div class="checkout-empty-state">
                    <svg class="checkout-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <h2 class="checkout-empty-title">Your Shopping Bag is Empty</h2>
                    <p class="checkout-empty-desc">You do not have any items in your bag yet. Explore our handcrafted collections of necklaces, bracelets, and earrings.</p>
                    <a href="<?= $base_path ?>shop/collections/index.php" class="btn-browse-collections">
                        <i class="fas fa-gem" aria-hidden="true"></i> Explore Collections
                    </a>
                </div>
            `;
            return;
        }

        let subtotal = 0;
        let rowsHtml = '';

        cart.forEach((item, index) => {
            const qty = parseInt(item.qty, 10) || 1;
            const price = parseFloat(item.priceNum) || 0;
            const lineTotal = price * qty;
            subtotal += lineTotal;

            const imgSrc = item.img || '<?= $base_path ?>assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';

            rowsHtml += `
                <tr>
                    <td>
                        <div class="cart-item-flex">
                            <img src="${imgSrc}" alt="${item.title || 'Product'}" class="cart-item-img">
                            <div>
                                <a href="${item.url || '#'}" class="cart-item-title">${item.title || 'Artisan Jewelry'}</a>
                            </div>
                        </div>
                    </td>
                    <td>${formatPrice(price)}</td>
                    <td>
                        <div class="qty-stepper">
                            <button type="button" class="qty-btn btn-qty-minus" data-index="${index}" aria-label="Decrease">&minus;</button>
                            <span class="qty-val">${qty}</span>
                            <button type="button" class="qty-btn btn-qty-plus" data-index="${index}" aria-label="Increase">&plus;</button>
                        </div>
                    </td>
                    <td style="font-weight: 600; color: var(--color-primary);">${formatPrice(lineTotal)}</td>
                    <td style="text-align: center;">
                        <button type="button" class="btn-remove-cart-item" data-index="${index}" title="Remove item" aria-label="Remove item">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        container.innerHTML = `
            <div class="cart-layout-grid">
                <div class="cart-table-card">
                    <table class="cart-items-table" aria-label="Shopping Bag Table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th style="text-align: center;">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rowsHtml}
                        </tbody>
                    </table>
                </div>

                <div class="cart-summary-card">
                    <h2 class="summary-heading" style="margin-bottom: 20px;">Cart Totals</h2>
                    <div class="summary-totals-table" style="border: none; padding: 0;">
                        <div class="summary-totals-row">
                            <span>Subtotal</span>
                            <strong>${formatPrice(subtotal)}</strong>
                        </div>
                        <div class="summary-totals-row">
                            <span>Delivery</span>
                            <span style="color: #2e7d32; font-weight: 600;">Complimentary</span>
                        </div>
                        <div class="summary-totals-row grand-total">
                            <span>Total</span>
                            <span class="grand-total-amount">${formatPrice(subtotal)}</span>
                        </div>
                    </div>
                    <a href="checkout.php" class="btn-proceed-checkout">
                        Proceed to Checkout <i class="fas fa-arrow-right" style="margin-left: 6px;"></i>
                    </a>
                </div>
            </div>
        `;

        bindCartEvents();
    }

    function bindCartEvents() {
        container.querySelectorAll('.btn-qty-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'), 10);
                const cart = getCart();
                if (cart[idx]) {
                    if (cart[idx].qty > 1) {
                        cart[idx].qty -= 1;
                    } else {
                        cart.splice(idx, 1);
                    }
                    saveCart(cart);
                    renderFullCart();
                }
            });
        });

        container.querySelectorAll('.btn-qty-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'), 10);
                const cart = getCart();
                if (cart[idx]) {
                    cart[idx].qty = (parseInt(cart[idx].qty, 10) || 1) + 1;
                    saveCart(cart);
                    renderFullCart();
                }
            });
        });

        container.querySelectorAll('.btn-remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.getAttribute('data-index'), 10);
                const cart = getCart();
                if (cart[idx]) {
                    cart.splice(idx, 1);
                    saveCart(cart);
                    renderFullCart();
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', renderFullCart);
    renderFullCart();
})();
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
