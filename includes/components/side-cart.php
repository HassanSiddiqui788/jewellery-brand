<?php
/**
 * Interactive Side Cart Drawer Component
 * Bijoux Jewelry Store
 */
$base_path = $base_path ?? './';
?>
<div class="elementor-menu-cart__container elementor-lightbox" id="bijoux-side-cart-drawer" aria-hidden="true">
    <div class="elementor-menu-cart__main" aria-hidden="true">
        <div class="vamtam-elementor-menu-cart__header">
            <span class="label">Shopping Bag</span>
            <span class="item-count">(0)</span>
            <button type="button" class="elementor-menu-cart__close-button" aria-label="Close Shopping Bag">
                <i class="vamtam-close vamtam-close-cart">&times;</i>
            </button>
        </div>
        <div class="widget_shopping_cart_content">
            <!-- Dynamically populated by nav-toggle.js via localStorage -->
            <div class="bijoux-mini-cart-empty">
                <svg class="bijoux-mini-cart-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <h3 class="bijoux-mini-cart-empty-title">Your Cart is Empty</h3>
                <p class="bijoux-mini-cart-empty-desc">Discover our artisan handcrafted collection to find your next signature piece.</p>
                <a href="<?= $base_path ?>shop/collections/index.php" class="bijoux-mini-cart-btn">Explore Collections</a>
            </div>
        </div>
    </div>
</div>
