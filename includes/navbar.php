<?php
/**
 * Universal Navigation Bar Component
 * Single Source of Truth for Lorem Ipsum Store
 */
require_once __DIR__ . '/../app/Services/AuthService.php';

$base_path = $base_path ?? './';

$current_script = basename($_SERVER['PHP_SELF'] ?? '');
$current_uri = $_SERVER['REQUEST_URI'] ?? '';
$is_home = ($current_script === 'index.php' && (strpos($current_uri, '/pages/') === false && strpos($current_uri, '/shop/') === false && strpos($current_uri, '/blog/') === false));
$is_about = ($current_script === 'about.php' || strpos($current_uri, 'about.php') !== false);
$is_collections = (strpos($current_uri, 'collections') !== false);

$is_logged_in = \App\Services\AuthService::check();
$logged_user = \App\Services\AuthService::user();
?>

<header class="site-header">
    <div class="site-header-inner">
        <!-- 1. Left: Desktop Navigation Menu -->
        <nav class="site-nav-desktop" aria-label="Main Navigation">
            <ul class="site-nav-list">
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>index.php" class="site-nav-link <?= $is_home ? 'active' : '' ?>">
                        <span class="nav-dash">&mdash;</span> HOME
                    </a>
                </li>
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>pages/about.php" class="site-nav-link <?= $is_about ? 'active' : '' ?>">
                        <span class="nav-dash">&mdash;</span> ABOUT US
                    </a>
                </li>
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>shop/collections/index.php" class="site-nav-link <?= $is_collections ? 'active' : '' ?>">
                        <span class="nav-dash">&mdash;</span> COLLECTIONS
                    </a>
                </li>
            </ul>
        </nav>

        <!-- 2. Center: Brand Logo -->
        <div class="site-logo-wrap">
            <a href="<?= $base_path ?>index.php" aria-label="Home" class="site-logo-link">
                <img width="156" height="30" src="<?= $base_path ?>assets/icons/logo.svg" alt="Lorem Ipsum" class="site-logo-img">
            </a>
        </div>

        <!-- 3. Right: Luxury Action Icons -->
        <div class="site-actions">
            <!-- Wishlist Button (Heart Icon) -->
            <a href="<?= $base_path ?>shop/collections/index.php" class="site-action-btn wishlist-btn" aria-label="Wishlist" title="Wishlist">
                <i class="far fa-heart" aria-hidden="true"></i>
            </a>

            <!-- Header Login / Logout Toggle -->
            <?php if ($is_logged_in): ?>
                <!-- Logout Button (User Icon switches to Logout when logged in) -->
                <button type="button" class="site-action-btn logout-btn header-logout-trigger" id="header-logout-btn" aria-label="Logout" title="Logout (<?= e($logged_user['full_name'] ?? 'Account') ?>)">
                    <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                </button>
            <?php else: ?>
                <!-- Login / Account Button (User Icon when not logged in) -->
                <a href="<?= $base_path ?>pages/login.php" class="site-action-btn login-btn account-btn" aria-label="Sign In / Account" title="Sign In / Account">
                    <i class="far fa-user" aria-hidden="true"></i>
                </a>
            <?php endif; ?>

            <!-- Shopping Bag / Cart Toggle -->
            <div class="elementor-menu-cart__toggle cart-toggle-wrap">
                <a id="elementor-menu-cart__toggle_button" href="<?= $base_path ?>shop/cart.php" class="cart-toggle-btn elementor-menu-cart__toggle_button" aria-label="Shopping Cart" aria-expanded="false" title="Shopping Bag">
                    <span class="cart-icon-wrap elementor-button-icon">
                        <span class="cart-badge elementor-button-icon-qty" data-counter="0">0</span>
                        <i class="e-toggle-cart-custom-icon vamtamtheme- vamtam-theme-shopping-bag" aria-hidden="true"></i>
                    </span>
                </a>
            </div>

            <!-- Mobile & Tablet Hamburger Button -->
            <button type="button" class="elementor-menu-toggle mobile-nav-toggle" aria-label="Toggle Mobile Menu" aria-expanded="false">
                <i class="elementor-menu-toggle__icon--open fas fa-bars" aria-hidden="true"></i>
                <i class="elementor-menu-toggle__icon--close fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <!-- 4. Mobile & Tablet Navigation Dropdown Drawer -->
    <nav class="elementor-nav-menu--dropdown elementor-nav-menu__container" aria-hidden="true">
        <ul id="mobile-menu-main" class="elementor-nav-menu">
            <li class="menu-item">
                <a href="<?= $base_path ?>index.php" class="elementor-item">Home</a>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="<?= $base_path ?>shop/index.php" class="elementor-item">
                    Shop
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?= $base_path ?>shop/index.php" class="elementor-sub-item">All Products</a></li>
                    <li><a href="<?= $base_path ?>shop/categories/necklaces/index.php" class="elementor-sub-item">Necklaces</a></li>
                    <li><a href="<?= $base_path ?>shop/categories/bracelets/index.php" class="elementor-sub-item">Bracelets</a></li>
                    <li><a href="<?= $base_path ?>shop/categories/earrings/index.php" class="elementor-sub-item">Earrings</a></li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="<?= $base_path ?>shop/collections/index.php" class="elementor-item">Categories</a>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#" class="elementor-item">
                    Pages
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <?php if ($is_logged_in): ?>
                        <li><a href="#" class="elementor-sub-item mobile-logout-trigger"><i class="fas fa-sign-out-alt" aria-hidden="true"></i> Logout (<?= e($logged_user['full_name'] ?? 'Account') ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?= $base_path ?>pages/login.php" class="elementor-sub-item">Sign In / Account</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $base_path ?>pages/about.php" class="elementor-sub-item">Our Story</a></li>
                    <li><a href="<?= $base_path ?>pages/customer-reviews.php" class="elementor-sub-item">Customer Reviews</a></li>
                    <li><a href="<?= $base_path ?>pages/retail-store.php" class="elementor-sub-item">Retail Store</a></li>
                    <li><a href="<?= $base_path ?>pages/faq.php" class="elementor-sub-item">FAQ</a></li>
                    <li><a href="<?= $base_path ?>pages/shipping.php" class="elementor-sub-item">Delivery &amp; Shipping</a></li>
                    <li><a href="<?= $base_path ?>pages/returns.php" class="elementor-sub-item">Returns &amp; Cancellations</a></li>
                    <li><a href="<?= $base_path ?>pages/privacy-policy.php" class="elementor-sub-item">Privacy Policy</a></li>
                    <li><a href="<?= $base_path ?>pages/terms.php" class="elementor-sub-item">Terms &amp; Conditions</a></li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="<?= $base_path ?>blog/index.php" class="elementor-item">
                    Blog
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?= $base_path ?>blog/index.php" class="elementor-sub-item">All Articles</a></li>
                    <li><a href="<?= $base_path ?>blog/posts/the-creative-journey-5-steps-to-reawaken-inspiration/index.php" class="elementor-sub-item">Creative Journey</a></li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="<?= $base_path ?>pages/contact.php" class="elementor-item">Contact</a>
            </li>
        </ul>
    </nav>
</header>

<!-- Logout Confirmation Modal -->
<div id="logout-confirm-modal" class="auth-modal-backdrop" aria-hidden="true" style="display: none;">
    <div class="auth-modal-box" role="dialog" aria-modal="true" aria-labelledby="logout-modal-title">
        <div class="auth-modal-header">
            <h4 id="logout-modal-title" class="auth-modal-title">Confirm Logout</h4>
            <button type="button" class="auth-modal-close" id="logout-modal-close" aria-label="Close modal">&times;</button>
        </div>
        <div class="auth-modal-body">
            <p class="auth-modal-message">Are you sure you want to logout?</p>
        </div>
        <div class="auth-modal-footer">
            <button type="button" class="auth-modal-btn btn-cancel" id="logout-modal-cancel">Cancel</button>
            <a href="<?= $base_path ?>pages/logout.php" class="auth-modal-btn btn-confirm" id="logout-modal-confirm">Confirm</a>
        </div>
    </div>
</div>

<!-- Logout Modal Trigger & Event Handler Script -->
<script>
(function() {
    function initLogoutModal() {
        var modal = document.getElementById('logout-confirm-modal');
        var cancelBtn = document.getElementById('logout-modal-cancel');
        var closeBtn = document.getElementById('logout-modal-close');
        var triggers = document.querySelectorAll('.header-logout-trigger, .mobile-logout-trigger');

        if (!modal) return;

        function openModal(e) {
            if (e) e.preventDefault();
            modal.style.display = 'flex';
            // Force browser reflow for smooth CSS transition
            modal.offsetHeight;
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(e) {
            if (e) e.preventDefault();
            modal.classList.remove('show');
            setTimeout(function() {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }, 250);
        }

        triggers.forEach(function(btn) {
            btn.addEventListener('click', openModal);
        });

        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Close on clicking backdrop outside the dialog box
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal(e);
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                closeModal(e);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLogoutModal);
    } else {
        initLogoutModal();
    }
})();
</script>
