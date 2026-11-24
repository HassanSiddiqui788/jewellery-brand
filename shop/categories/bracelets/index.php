<?php
/**
 * Category: Bracelets – JARWAYA JEWELS
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Bracelets – JARWAYA JEWELS';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

// Fetch active bracelets dynamically from MySQL database
$products = get_catalog_products('bracelets');
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Bracelets</h1>
        <p class="about-page-subtitle">Artisanal cuffs, sculpted bangles, and delicate wrist adornments.</p>
        <div class="site-category-pills">
            <a href="<?= $base_path ?>shop/index.php">All Pieces</a>
            <a href="<?= $base_path ?>shop/categories/necklaces/index.php">Necklaces</a>
            <a href="<?= $base_path ?>shop/categories/bracelets/index.php" class="active">Bracelets</a>
            <a href="<?= $base_path ?>shop/categories/earrings/index.php">Earrings</a>
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
                            <div class="home-product-meta"><?= e($prod->categoryName ?? 'Bracelets') ?> &bull; handcrafted</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <a href="<?= $base_path ?>shop/product/miro-jewelry-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Miro Jewelry Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Miro Jewelry Golden Bracelet</h3>
                        <div class="home-product-price">Rs. 18,500</div>
                        <div class="home-product-meta">bracelets &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/arquitectura-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3371po033200.pw-1280-420x381.jpg" alt="Arquitectura Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Arquitectura Golden Bracelet</h3>
                        <div class="home-product-price">Rs. 21,000</div>
                        <div class="home-product-meta">bracelets &bull; handcrafted</div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
