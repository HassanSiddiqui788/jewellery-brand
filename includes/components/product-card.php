<?php
/**
 * Product Card Component
 * Lorem Ipsum Store
 *
 * @param array $product Array containing title, price, image, url, and optional badge
 */
if (!defined('BIJOUX_APP')) {
    require_once __DIR__ . '/../config.php';
}
$base_path = $base_path ?? './';
$p_title = htmlspecialchars($product['title'] ?? 'Jewelry Piece');
$p_price = htmlspecialchars($product['price'] ?? '$0.00');
$p_image = htmlspecialchars(ltrim($product['image'] ?? 'assets/images/placeholder.jpg', '/'));
$p_url = htmlspecialchars($product['url'] ?? '#');
$p_badge = htmlspecialchars($product['badge'] ?? '');
?>
<li class="product type-product post-item elementor-grid-item">
    <div class="product-inner">
        <div class="product-thumbnail">
            <a href="<?= $p_url ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <?php if ($p_badge): ?>
                    <span class="onsale"><?= $p_badge ?></span>
                <?php endif; ?>
                <img width="630" height="875" src="<?= $base_path . $p_image ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="<?= $p_title ?>" loading="lazy" />
            </a>
        </div>
        <div class="product-summary">
            <h2 class="woocommerce-loop-product__title">
                <a href="<?= $p_url ?>"><?= $p_title ?></a>
            </h2>
            <span class="price"><span class="woocommerce-Price-amount amount"><bdi><?= $p_price ?></bdi></span></span>
            <div class="product-actions">
                <a href="<?= $p_url ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart">View Piece</a>
            </div>
        </div>
    </div>
</li>
