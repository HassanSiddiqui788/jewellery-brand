<?php
/**
 * Page: Shop All Jewelry – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shop All Jewelry – Lorem Ipsum';
$body_class = 'archive post-type-archive post-type-archive-product wp-custom-logo woocommerce woocommerce-page full header-layout-logo-menu has-page-header no-middle-header responsive-layout vamtam-is-elementor elementor-default elementor-kit-4';
$current_page = 'collections';

$page_css = 'post-4964.css';
require_once __DIR__ . '/../includes/header.php';

$categories = $categories ?? [
    ['name' => 'All Pieces', 'url' => 'shop/index.php', 'active' => true],
    ['name' => 'Necklaces', 'url' => 'shop/categories/necklaces/index.php', 'active' => false],
    ['name' => 'Bracelets', 'url' => 'shop/categories/bracelets/index.php', 'active' => false],
    ['name' => 'Earrings', 'url' => 'shop/categories/earrings/index.php', 'active' => false],
];

$featured_products = $featured_products ?? [
    [
        'title' => 'Splash Golden Necklace',
        'price' => '$369.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => $base_path . 'shop/product/splash-golden-necklace/index.php',
        'badge' => 'New'
    ],
    [
        'title' => 'Curves Golden Earrings',
        'price' => '$195.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => $base_path . 'shop/product/curves-golden-earrings/index.php',
        'badge' => ''
    ],
    [
        'title' => 'Miro Jewelry Golden Bracelet',
        'price' => '$219.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => $base_path . 'shop/product/miro-jewelry-golden-bracelet/index.php',
        'badge' => 'Featured'
    ]
];
?>

<div class="site-shop-header">
    <h1>Lorem Ipsum Catalog</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <div class="site-category-pills">
        <?php foreach ($categories as $cat): 
            $cat_href = site_url($cat['url'], $base_path);
        ?>
            <a href="<?= $cat_href ?>" class="<?= $cat['active'] ? 'active' : '' ?>"><?= e($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>
</div>

<div class="site-shop-container woocommerce">
    <ul class="site-products-grid products">
        <?php foreach ($featured_products as $product): ?>
            <?php include __DIR__ . '/../includes/components/product-card.php'; ?>
        <?php endforeach; ?>
    </ul>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
