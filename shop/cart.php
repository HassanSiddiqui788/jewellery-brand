<?php
/**
 * Page: Shopping Cart – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shopping Cart – Bijoux';
$body_class = 'page-template-default page woocommerce-cart woocommerce-page wp-custom-logo wp-theme-bijoux theme-bijoux full header-layout-logo-menu has-page-header no-middle-header responsive-layout vamtam-is-elementor elementor-default elementor-kit-4';
$current_page = 'collections';

require_once __DIR__ . '/../includes/header.php';
?>


<div class="bijoux-cart-wrapper">
    <h1>Your Shopping Bag</h1>
    <div class="bijoux-cart-empty-box">
        <p>Your shopping bag is currently empty.</p>
        <a href="<?= $base_path ?>shop/collections/index.php" class="bijoux-cart-btn">Explore Collections</a>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
