<?php
/**
 * Page: Checkout – Lorem Ipsum
 * Dynamic luxury checkout with customer & delivery details, payment selection,
 * order review, and seamless MySQL database order placement.
 */

require_once __DIR__ . '/../includes/config.php';

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    if (function_exists('app') && app()->has('session')) {
        app()->session()->start();
    } else {
        @session_start();
    }
}

$base_path = '../';
$page_title = 'Checkout – Lorem Ipsum';
$body_class = 'page page-checkout';
$current_page = 'checkout';
$page_css = ['checkout.css'];

// Check logged in customer
$isLoggedIn = !empty($_SESSION['user_id']);
$loggedInUser = [
    'id'        => $_SESSION['user_id'] ?? null,
    'full_name' => $_SESSION['user_name'] ?? '',
    'email'     => $_SESSION['user_email'] ?? '',
];

// Check flash errors/old values
$flashErrors = $_SESSION['checkout_errors'] ?? [];
$flashOld = $_SESSION['checkout_old'] ?? [];
unset($_SESSION['checkout_errors'], $_SESSION['checkout_old']);

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="checkout-page-container">
    <!-- Breadcrumb & Hero -->
    <header class="checkout-hero-banner">
        <nav class="checkout-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= $base_path ?>index.php">Home</a>
            <span class="sep">/</span>
            <a href="<?= $base_path ?>shop/cart.php">Shopping Bag</a>
            <span class="sep">/</span>
            <span aria-current="page">Checkout</span>
        </nav>
        <h1 class="checkout-title">Secure Checkout</h1>
        <p class="checkout-subtitle">Review your luxury artisan selections and provide your delivery details below.</p>
    </header>

    <!-- Global Alert Notification -->
    <div id="checkoutAlert" class="checkout-alert" role="alert">
        <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
        <span id="checkoutAlertMsg"></span>
    </div>

    <!-- Empty Bag State (displayed if localStorage has no items) -->
    <div id="checkoutEmptyState" class="checkout-empty-state" style="display: none;">
        <svg class="checkout-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
        </svg>
        <h2 class="checkout-empty-title">Your Shopping Bag is Empty</h2>
        <p class="checkout-empty-desc">You do not have any items in your shopping bag. Discover our signature handcrafted jewelry before completing your order.</p>
        <a href="<?= $base_path ?>shop/collections/index.php" class="btn-browse-collections">
            <i class="fas fa-gem" aria-hidden="true"></i> Explore Collections
        </a>
    </div>

    <!-- Main Checkout Form & Summary Grid -->
    <section id="checkoutFormSection" aria-label="Checkout Process">
        <form id="checkoutOrderForm" method="POST" action="process-order.php" novalidate>
            <input type="hidden" name="ajax" value="1">
            <input type="hidden" name="cart_items" id="cartItemsInput" value="">
            <?php if ($isLoggedIn && !empty($loggedInUser['id'])): ?>
                <input type="hidden" name="user_id" value="<?= (int) $loggedInUser['id'] ?>">
            <?php endif; ?>

            <div class="checkout-layout-grid">
                <!-- Left Column: Details & Payment -->
                <div class="checkout-form-column">
                    <!-- 1. Customer Contact Details -->
                    <div class="checkout-section-card">
                        <h2 class="checkout-section-title">
                            <span>1. Customer Information</span>
                            <span class="section-step">Step 1</span>
                        </h2>

                        <?php if ($isLoggedIn): ?>
                            <div class="auth-notice-pill">
                                <div>
                                    <i class="fas fa-user-check" style="color: var(--color-accent); margin-right: 6px;"></i>
                                    Logged in as <span class="auth-user"><?= htmlspecialchars($loggedInUser['full_name']) ?></span>
                                </div>
                                <span style="font-size: 11px; opacity: 0.7;"><?= htmlspecialchars($loggedInUser['email']) ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="customerName" class="form-label">Full Name <span class="req">*</span></label>
                                <input type="text" id="customerName" name="full_name" class="form-control" 
                                       placeholder="e.g. Sophia Sterling" 
                                       value="<?= htmlspecialchars($flashOld['full_name'] ?? $loggedInUser['full_name'] ?? '') ?>" required>
                                <div class="field-error-msg" id="err-full_name">Please enter your full name.</div>
                            </div>

                            <div class="form-group">
                                <label for="customerEmail" class="form-label">Email Address <span class="req">*</span></label>
                                <input type="email" id="customerEmail" name="email" class="form-control" 
                                       placeholder="e.g. sophia@example.com" 
                                       value="<?= htmlspecialchars($flashOld['email'] ?? $loggedInUser['email'] ?? '') ?>" required>
                                <div class="field-error-msg" id="err-email">Please enter a valid email address.</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="customerPhone" class="form-label">Phone Number <span class="req">*</span></label>
                            <input type="tel" id="customerPhone" name="phone" class="form-control" 
                                   placeholder="e.g. +92 300 1234567" 
                                   value="<?= htmlspecialchars($flashOld['phone'] ?? '') ?>" required>
                            <div class="field-error-msg" id="err-phone">Please enter your contact phone number.</div>
                        </div>
                    </div>

                    <!-- 2. Shipping Address -->
                    <div class="checkout-section-card">
                        <h2 class="checkout-section-title">
                            <span>2. Delivery Address</span>
                            <span class="section-step">Step 2</span>
                        </h2>

                        <div class="form-group">
                            <label for="shippingAddress" class="form-label">Street Address <span class="req">*</span></label>
                            <input type="text" id="shippingAddress" name="address" class="form-control" 
                                   placeholder="House/Plot number, street, sector or area" 
                                   value="<?= htmlspecialchars($flashOld['address'] ?? '') ?>" required>
                            <div class="field-error-msg" id="err-address">Please provide your complete delivery street address.</div>
                        </div>

                        <div class="form-group">
                            <label for="shippingApartment" class="form-label">Apartment, Suite, Unit (Optional)</label>
                            <input type="text" id="shippingApartment" name="apartment" class="form-control" 
                                   placeholder="Apartment, suite, or unit number" 
                                   value="<?= htmlspecialchars($flashOld['apartment'] ?? '') ?>">
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="shippingCity" class="form-label">Town / City <span class="req">*</span></label>
                                <input type="text" id="shippingCity" name="city" class="form-control" 
                                       placeholder="e.g. Karachi, Lahore, Islamabad" 
                                       value="<?= htmlspecialchars($flashOld['city'] ?? '') ?>" required>
                                <div class="field-error-msg" id="err-city">Please specify your city.</div>
                            </div>

                            <div class="form-group">
                                <label for="shippingState" class="form-label">State / Province</label>
                                <input type="text" id="shippingState" name="state" class="form-control" 
                                       placeholder="e.g. Sindh, Punjab" 
                                       value="<?= htmlspecialchars($flashOld['state'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="shippingPostalCode" class="form-label">Postal / ZIP Code</label>
                                <input type="text" id="shippingPostalCode" name="postal_code" class="form-control" 
                                       placeholder="e.g. 75500" 
                                       value="<?= htmlspecialchars($flashOld['postal_code'] ?? '') ?>">
                            </div>

                            <div class="form-group">
                                <label for="shippingCountry" class="form-label">Country</label>
                                <select id="shippingCountry" name="country" class="form-control">
                                    <option value="Pakistan" selected>Pakistan</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Payment Method -->
                    <div class="checkout-section-card">
                        <h2 class="checkout-section-title">
                            <span>3. Payment Method</span>
                            <span class="section-step">Step 3</span>
                        </h2>

                        <div class="payment-methods-list" role="radiogroup" aria-label="Payment Method Selection">
                            <!-- Option 1: Cash on Delivery -->
                            <label class="payment-method-card active" for="paymentCod">
                                <div class="payment-method-header">
                                    <input type="radio" id="paymentCod" name="payment_method" value="cod" checked>
                                    <span class="payment-method-title">Cash on Delivery (COD)</span>
                                    <div class="payment-method-icons">
                                        <i class="fas fa-money-bill-wave" title="Cash"></i>
                                    </div>
                                </div>
                                <div class="payment-method-desc">
                                    Pay securely in cash upon hand delivery of your luxury parcel at your doorstep.
                                </div>
                            </label>

                            <!-- Option 2: Direct Bank Transfer -->
                            <label class="payment-method-card" for="paymentBank">
                                <div class="payment-method-header">
                                    <input type="radio" id="paymentBank" name="payment_method" value="bank_transfer">
                                    <span class="payment-method-title">Direct Bank Transfer</span>
                                    <div class="payment-method-icons">
                                        <i class="fas fa-university" title="Bank Transfer"></i>
                                    </div>
                                </div>
                                <div class="payment-method-desc">
                                    Transfer directly to our official bank account. Bank details will be provided immediately upon order confirmation.
                                </div>
                            </label>

                            <!-- Option 3: Credit / Debit Card -->
                            <label class="payment-method-card" for="paymentCard">
                                <div class="payment-method-header">
                                    <input type="radio" id="paymentCard" name="payment_method" value="card">
                                    <span class="payment-method-title">Credit / Debit Card</span>
                                    <div class="payment-method-icons">
                                        <i class="fab fa-cc-visa" title="Visa"></i>
                                        <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                                    </div>
                                </div>
                                <div class="payment-method-desc">
                                    Encrypted end-to-end checkout. Instant verification and priority packaging.
                                </div>
                                <div id="cardFieldsBox" class="card-fields-box" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">Card Number</label>
                                        <input type="text" class="form-control" placeholder="4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242" maxlength="19">
                                    </div>
                                    <div class="form-row-2">
                                        <div class="form-group">
                                            <label class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" placeholder="MM / YY" maxlength="7">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">CVC / CVV</label>
                                            <input type="password" class="form-control" placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 4. Order Notes -->
                    <div class="checkout-section-card">
                        <h2 class="checkout-section-title">
                            <span>4. Special Instructions (Optional)</span>
                        </h2>
                        <div class="form-group">
                            <label for="orderNotes" class="form-label">Order Notes / Custom Requests</label>
                            <textarea id="orderNotes" name="notes" class="form-control" rows="3" 
                                      placeholder="Notes about your order, e.g. special gift wrapping or delivery directions."><?= htmlspecialchars($flashOld['notes'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="checkout-summary-column">
                    <div class="checkout-summary-card">
                        <h2 class="summary-heading">
                            <span>Your Order</span>
                            <span id="summaryItemCount" style="font-size: 13px; font-weight: 500; color: var(--color-muted);">(0 items)</span>
                        </h2>

                        <!-- Dynamic Items List -->
                        <div id="checkoutSummaryItems" class="summary-items-list" aria-label="Ordered pieces">
                            <!-- Populated dynamically via JS -->
                        </div>

                        <!-- Totals Breakdown -->
                        <div class="summary-totals-table">
                            <div class="summary-totals-row">
                                <span>Subtotal</span>
                                <strong id="checkoutSubtotal">$0.00</strong>
                            </div>
                            <div class="summary-totals-row">
                                <span>Delivery</span>
                                <span style="color: #2e7d32; font-weight: 600;">Complimentary</span>
                            </div>
                            <div class="summary-totals-row grand-total">
                                <span>Grand Total</span>
                                <span id="checkoutGrandTotal" class="grand-total-amount">$0.00</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="placeOrderBtn" class="btn-place-order">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <span id="btnText">Place Order &bull; $0.00</span>
                        </button>

                        <!-- Trust Guarantees -->
                        <div class="checkout-trust-badges">
                            <div class="trust-badge-item">
                                <i class="fas fa-shield-alt" aria-hidden="true"></i>
                                <span>256-Bit SSL Bank-Grade Encryption</span>
                            </div>
                            <div class="trust-badge-item">
                                <i class="fas fa-certificate" aria-hidden="true"></i>
                                <span>100% Certified Authentic Artisan Jewelry</span>
                            </div>
                            <div class="trust-badge-item">
                                <i class="fas fa-shipping-fast" aria-hidden="true"></i>
                                <span>Insured Luxury Hand Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>

<script>
(function() {
    'use strict';

    const CART_KEY = 'bijoux_cart_items';
    const form = document.getElementById('checkoutOrderForm');
    const formSection = document.getElementById('checkoutFormSection');
    const emptyState = document.getElementById('checkoutEmptyState');
    const itemsContainer = document.getElementById('checkoutSummaryItems');
    const cartInput = document.getElementById('cartItemsInput');
    const subtotalEl = document.getElementById('checkoutSubtotal');
    const grandTotalEl = document.getElementById('checkoutGrandTotal');
    const btnText = document.getElementById('btnText');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    const itemCountEl = document.getElementById('summaryItemCount');
    const alertBox = document.getElementById('checkoutAlert');
    const alertMsg = document.getElementById('checkoutAlertMsg');

    function getCart() {
        try {
            const raw = localStorage.getItem(CART_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }

    function formatPrice(num) {
        return '$' + parseFloat(num).toFixed(2);
    }

    function showAlert(message, isSuccess = false) {
        alertMsg.textContent = message;
        alertBox.className = 'checkout-alert ' + (isSuccess ? 'alert-success' : 'alert-danger');
        alertBox.style.display = 'flex';
        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideAlert() {
        alertBox.style.display = 'none';
    }

    function renderCheckoutItems() {
        const cart = getCart();

        if (!cart || cart.length === 0) {
            formSection.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        formSection.style.display = 'block';
        emptyState.style.display = 'none';

        // Serialize into hidden field for server validation
        cartInput.value = JSON.stringify(cart);

        let subtotal = 0;
        let totalQty = 0;
        let html = '';

        cart.forEach(function(item) {
            const qty = parseInt(item.qty, 10) || 1;
            const price = parseFloat(item.priceNum) || 0;
            const lineTotal = price * qty;
            subtotal += lineTotal;
            totalQty += qty;

            const imgSrc = item.img || '<?= $base_path ?>assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';

            html += `
                <div class="summary-item-row">
                    <div class="summary-item-thumb">
                        <img src="${imgSrc}" alt="${item.title || 'Jewelry Piece'}">
                        <span class="summary-item-qty-badge">${qty}</span>
                    </div>
                    <div class="summary-item-info">
                        <div class="summary-item-name" title="${item.title || 'Artisan Jewelry'}">${item.title || 'Artisan Jewelry'}</div>
                        <div class="summary-item-price-each">${formatPrice(price)} each</div>
                    </div>
                    <div class="summary-item-total">${formatPrice(lineTotal)}</div>
                </div>
            `;
        });

        itemsContainer.innerHTML = html;
        subtotalEl.textContent = formatPrice(subtotal);
        grandTotalEl.textContent = formatPrice(subtotal);
        itemCountEl.textContent = '(' + totalQty + (totalQty === 1 ? ' piece' : ' pieces') + ')';
        btnText.textContent = 'Place Order • ' + formatPrice(subtotal);
    }

    // Payment method radio selector interaction
    const paymentCards = document.querySelectorAll('.payment-method-card');
    const cardFieldsBox = document.getElementById('cardFieldsBox');

    paymentCards.forEach(card => {
        card.addEventListener('click', function() {
            paymentCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                if (cardFieldsBox) {
                    cardFieldsBox.style.display = (radio.value === 'card') ? 'block' : 'none';
                }
            }
        });
    });

    // Form Submission Handling
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        hideAlert();

        const cart = getCart();
        if (!cart || cart.length === 0) {
            showAlert('Your shopping bag is empty. Please add items before checking out.');
            return;
        }

        // Validate required fields
        let hasError = false;
        const requiredFields = [
            { id: 'customerName', errId: 'err-full_name' },
            { id: 'customerEmail', errId: 'err-email' },
            { id: 'customerPhone', errId: 'err-phone' },
            { id: 'shippingAddress', errId: 'err-address' },
            { id: 'shippingCity', errId: 'err-city' }
        ];

        requiredFields.forEach(field => {
            const input = document.getElementById(field.id);
            const errEl = document.getElementById(field.errId);
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                if (errEl) errEl.style.display = 'block';
                if (!hasError) input.focus();
                hasError = true;
            } else {
                input.classList.remove('is-invalid');
                if (errEl) errEl.style.display = 'none';
            }
        });

        // Email validation
        const emailInput = document.getElementById('customerEmail');
        const emailErr = document.getElementById('err-email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailInput.value.trim() && !emailRegex.test(emailInput.value.trim())) {
            emailInput.classList.add('is-invalid');
            if (emailErr) {
                emailErr.textContent = 'Please enter a valid email address.';
                emailErr.style.display = 'block';
            }
            if (!hasError) emailInput.focus();
            hasError = true;
        }

        if (hasError) {
            showAlert('Please complete all required fields marked in red.');
            return;
        }

        // Lock form & show loading spinner
        placeOrderBtn.disabled = true;
        const originalBtnHtml = placeOrderBtn.innerHTML;
        placeOrderBtn.innerHTML = '<span class="spinner-icon"></span> Processing Order...';

        const formData = new FormData(form);
        formData.set('cart_items', JSON.stringify(cart));

        fetch('process-order.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => {
            return response.json().then(data => ({
                status: response.status,
                data: data
            }));
        })
        .then(result => {
            if (result.data && result.data.success) {
                // Clear cart from localStorage upon successful order placement
                localStorage.removeItem(CART_KEY);

                // Update site header badge counters to 0
                document.querySelectorAll('.elementor-button-icon-qty').forEach(b => {
                    b.textContent = '0';
                    b.setAttribute('data-counter', '0');
                });

                showAlert('Order placed successfully! Redirecting...', true);

                setTimeout(() => {
                    window.location.href = result.data.redirect_url;
                }, 600);
            } else {
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerHTML = originalBtnHtml;

                const errors = (result.data && result.data.errors) ? result.data.errors : {};
                let errMsg = 'Could not place your order. Please check your details.';
                if (typeof errors === 'string') {
                    errMsg = errors;
                } else if (typeof errors === 'object') {
                    const firstKey = Object.keys(errors)[0];
                    if (firstKey) {
                        errMsg = errors[firstKey];
                        const inputEl = form.querySelector(`[name="${firstKey}"]`);
                        if (inputEl) inputEl.classList.add('is-invalid');
                    }
                }
                showAlert(errMsg);
            }
        })
        .catch(err => {
            placeOrderBtn.disabled = false;
            placeOrderBtn.innerHTML = originalBtnHtml;
            showAlert('A network error occurred while submitting your order. Please try again.');
        });
    });

    // Realtime invalid class removal on typing
    form.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errEl = this.parentElement.querySelector('.field-error-msg');
            if (errEl) errEl.style.display = 'none';
        });
    });

    // Render items on page load
    document.addEventListener('DOMContentLoaded', renderCheckoutItems);
    renderCheckoutItems();
})();
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
