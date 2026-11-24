<?php
/**
 * Category: Earrings – JARWAYA JEWELS
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Earrings – JARWAYA JEWELS';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

// Fetch active earrings dynamically from MySQL database
$products = get_catalog_products('earrings');
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Earrings</h1>
        <p class="about-page-subtitle">Architectural drops, organic hoops, and luminous golden studs.</p>
        <div class="site-category-pills">
            <a href="<?= $base_path ?>shop/index.php">All Pieces</a>
            <a href="<?= $base_path ?>shop/categories/necklaces/index.php">Necklaces</a>
            <a href="<?= $base_path ?>shop/categories/bracelets/index.php">Bracelets</a>
            <a href="<?= $base_path ?>shop/categories/earrings/index.php" class="active">Earrings</a>
        </div>
    </header>

    <div class="about-container" style="max-width: var(--site-max-width);">
        <div class="home-products-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $prod): ?>
                    <a href="<?= $base_path ?>shop/product/<?= esc_attr($prod->slug) ?>/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?><?= esc_attr($prod->mainImage) ?>" alt="<?= esc_attr($prod->name) ?>" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title"><?= e($prod->name) ?></h3>
                            <div class="home-product-price"><?= format_price($prod->effectivePrice()) ?></div>
                            <div class="home-product-meta"><?= e($prod->categoryName ?? 'Earrings') ?> &bull; handcrafted</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <a href="<?= $base_path ?>shop/product/curves-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg" alt="Curves Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Curves Golden Earrings</h3>
                        <div class="home-product-price">Rs. 14,500</div>
                        <div class="home-product-meta">earrings &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/portlligat-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Portlligat Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Portlligat Golden Earrings</h3>
                        <div class="home-product-price">Rs. 11,500</div>
                        <div class="home-product-meta">earrings &bull; handcrafted</div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
