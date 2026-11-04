<?php
/**
 * Page: Shop All Jewelry – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shop All Jewelry – Bijoux';
$body_class = 'archive post-type-archive post-type-archive-product wp-custom-logo wp-theme-bijoux theme-bijoux woocommerce woocommerce-page full header-layout-logo-menu has-page-header no-middle-header responsive-layout vamtam-is-elementor elementor-default elementor-kit-4';
$current_page = 'collections';

$page_css = 'post-4964.css';
require_once __DIR__ . '/../includes/header.php';

$categories = $categories ?? [
    ['name' => 'All Pieces', 'url' => 'shop/index.php', 'active' => true],
    ['name' => 'Earrings', 'url' => 'shop/collections/index.php', 'active' => false],
    ['name' => 'Necklaces', 'url' => 'shop/collections/index.php', 'active' => false],
    ['name' => 'Rings', 'url' => 'shop/collections/index.php', 'active' => false],
    ['name' => 'Bracelets', 'url' => 'shop/collections/index.php', 'active' => false],
];

$featured_products = $featured_products ?? [
    [
        'title' => 'Aura Diamond Pendant',
        'price' => '$340.00',
        'image' => 'assets/images/home-banner-images/revslider_1.jpg',
        'url' => $base_path . 'shop/product/index.php',
        'badge' => 'New'
    ],
    [
        'title' => 'Solstice Gold Hoop Earrings',
        'price' => '$220.00',
        'image' => 'assets/images/home-banner-images/revslider_3.jpg',
        'url' => $base_path . 'shop/product/index.php',
        'badge' => ''
    ],
    [
        'title' => 'Eternity Diamond Ring',
        'price' => '$580.00',
        'image' => 'assets/images/home-banner-images/revslider_2.jpg',
        'url' => $base_path . 'shop/product/index.php',
        'badge' => 'Featured'
    ]
];
?>


<div class="bijoux-shop-header">
    <h1>Artisan Jewelry Catalog</h1>
    <p>Discover our meticulously handcrafted collections made with authentic precious metals, fine gold vermeil, and sustainably sourced gemstones.</p>
    <div class="bijoux-category-pills">
        <?php foreach ($categories as $cat): 
            $cat_href = site_url($cat['url'], $base_path);
        ?>
            <a href="<?= $cat_href ?>" class="<?= $cat['active'] ? 'active' : '' ?>"><?= e($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>
</div>

<div class="bijoux-shop-container woocommerce">
    <ul class="bijoux-products-grid products">
        <?php foreach ($featured_products as $product): ?>
            <?php include __DIR__ . '/../includes/components/product-card.php'; ?>
        <?php endforeach; ?>
    </ul>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
