<?php
/**
 * Page: Checkout – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Checkout – Bijoux';
$body_class = 'page-template-default page woocommerce-checkout woocommerce-page wp-custom-logo wp-theme-bijoux theme-bijoux full header-layout-logo-menu has-page-header no-middle-header responsive-layout vamtam-is-elementor elementor-default elementor-kit-4';
$current_page = 'collections';

require_once __DIR__ . '/../includes/header.php';
?>


<div class="bijoux-checkout-wrapper">
    <h1>Checkout</h1>
    <div class="bijoux-checkout-box">
        <p>You do not have any items in your bag yet. Please add your favorite jewelry pieces to proceed with checkout.</p>
        <a href="<?= $base_path ?>shop/collections/index.php" class="bijoux-checkout-btn">Return to Shop</a>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
