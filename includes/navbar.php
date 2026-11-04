<?php
/**
 * Universal Navigation Bar Component
 * Single Source of Truth for Bijoux Jewelry Store
 */
$base_path = $base_path ?? './';
?>
<header class="site-header">
    <div class="site-header-inner">
        <!-- 1. Left: Desktop Navigation Menu -->
        <nav class="site-nav-desktop" aria-label="Main Navigation">
            <ul class="site-nav-list">
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>index.php" class="site-nav-link">Home</a>
                </li>
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>pages/about.php" class="site-nav-link">
                        About <i class="fas fa-caret-down" style="font-size: 10px; margin-left: 2px;"></i>
                    </a>
                    <ul class="site-dropdown">
                        <li><a href="<?= $base_path ?>pages/about.php">Our Story</a></li>
                        <li><a href="<?= $base_path ?>blog/index.php">Journal</a></li>
                        <li><a href="<?= $base_path ?>pages/our-materials.php">Our Materials</a></li>
                        <li><a href="<?= $base_path ?>pages/contact.php">Contact Us</a></li>
                    </ul>
                </li>
                <li class="site-nav-item mega-menu">
                    <a href="<?= $base_path ?>shop/collections/index.php" class="site-nav-link mega-menu">Collections</a>
                </li>
                <li class="site-nav-item">
                    <a href="<?= $base_path ?>shop/index.php" class="site-nav-link">
                        Shop <i class="fas fa-caret-down" style="font-size: 10px; margin-left: 2px;"></i>
                    </a>
                    <ul class="site-dropdown">
                        <li><a href="<?= $base_path ?>shop/index.php">All Products</a></li>
                        <li><a href="<?= $base_path ?>pages/gift-cards.php">Gift Cards</a></li>
                        <li><a href="<?= $base_path ?>pages/customer-reviews.php">Customer Reviews</a></li>
                        <li><a href="<?= $base_path ?>pages/retail-store.php">Retail Store</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- 2. Center: Brand Logo -->
        <div class="site-logo-wrap">
            <a href="<?= $base_path ?>index.php" aria-label="Bijoux Home">
                <img width="156" height="30" src="<?= $base_path ?>assets/icons/logo.svg" alt="Bijoux Jewelry" class="site-logo-img">
            </a>
        </div>

        <!-- 3. Right: Actions & Cart -->
        <div class="site-actions">
            <!-- Shopping Bag / Cart Toggle -->
            <div class="elementor-menu-cart__toggle cart-toggle-wrap">
                <a id="elementor-menu-cart__toggle_button" href="<?= $base_path ?>shop/cart.php" class="cart-toggle-btn elementor-menu-cart__toggle_button" aria-label="Shopping Cart" aria-expanded="false">
                    <span class="cart-amount-text woocommerce-Price-amount amount">
                        <bdi><span class="woocommerce-Price-currencySymbol" translate="no">&#36;</span>0.00</bdi>
                    </span>
                    <span class="cart-icon-wrap elementor-button-icon">
                        <span class="cart-badge elementor-button-icon-qty" data-counter="0">0</span>
                        <i class="e-toggle-cart-custom-icon vamtamtheme- vamtam-theme-shopping-bag" aria-hidden="true" style="font-size: 20px;"></i>
                    </span>
                </a>
            </div>

            <!-- Desktop Side Menu Hamburger Toggle (Popup 998) -->
            <a href="#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6Ijk5OCIsInRvZ2dsZSI6dHJ1ZSwiYWxpZ25fd2l0aF9wYXJlbnQiOiIifQ%3D%3D" 
               class="site-action-btn vamtam-popup-toggle" 
               aria-label="Open Side Menu" 
               role="button"
               title="Side Menu">
                <i aria-hidden="true" class="vamtamtheme- vamtam-theme-side-menu" style="font-size: 20px;"></i>
            </a>

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
                <a href="#" class="elementor-item">
                    About
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?= $base_path ?>pages/about.php" class="elementor-sub-item">Our Story</a></li>
                    <li><a href="<?= $base_path ?>blog/index.php" class="elementor-sub-item">Journal</a></li>
                    <li><a href="<?= $base_path ?>pages/our-materials.php" class="elementor-sub-item">Our Materials</a></li>
                    <li><a href="<?= $base_path ?>pages/contact.php" class="elementor-sub-item">Contact Us</a></li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="<?= $base_path ?>shop/collections/index.php" class="elementor-item">Collections</a>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#" class="elementor-item">
                    Shop
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?= $base_path ?>shop/index.php" class="elementor-sub-item">All Products</a></li>
                    <li><a href="<?= $base_path ?>pages/gift-cards.php" class="elementor-sub-item">Gift Cards</a></li>
                    <li><a href="<?= $base_path ?>pages/customer-reviews.php" class="elementor-sub-item">Customer Reviews</a></li>
                    <li><a href="<?= $base_path ?>pages/retail-store.php" class="elementor-sub-item">Retail Store</a></li>
                </ul>
            </li>
            <li class="menu-item menu-item-has-children">
                <a href="#" class="elementor-item">
                    Customer Care
                    <span class="sub-arrow"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
                </a>
                <ul class="sub-menu">
                    <li><a href="<?= $base_path ?>pages/shipping.php" class="elementor-sub-item">Delivery</a></li>
                    <li><a href="<?= $base_path ?>pages/returns.php" class="elementor-sub-item">Return &amp; Cancellations</a></li>
                    <li><a href="<?= $base_path ?>pages/faq.php" class="elementor-sub-item">FAQ</a></li>
                    <li><a href="<?= $base_path ?>pages/privacy-policy.php" class="elementor-sub-item">Privacy Policy</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
