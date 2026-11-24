<?php
/**
 * Page: Shop All Fine Jewellery – JARWAYA JEWELS
 * Handcrafted Fine Jewellery & Modern Heirlooms
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shop All Fine Jewellery – JARWAYA JEWELS';
$body_class = 'archive post-type-archive post-type-archive-product page-shop';
$current_page = 'collections';

require_once __DIR__ . '/../includes/header.php';

// Fetch active products dynamically from MySQL database
$products = get_catalog_products(null, 24);
?>

<main id="main-content" class="site-main">
    <!-- Luxury Page Header -->
    <header class="about-page-header">
        <h1 class="about-page-title">Fine Jewellery Gallery</h1>
        <p class="about-page-subtitle">Discover our complete collection of handcrafted necklaces, bracelets, and earrings designed for timeless elegance.</p>
        
        <!-- Category Filter Pills -->
        <div class="site-category-pills">
            <a href="<?= $base_path ?>shop/index.php" class="active">All Pieces</a>
            <a href="<?= $base_path ?>shop/categories/necklaces/index.php">Necklaces</a>
            <a href="<?= $base_path ?>shop/categories/bracelets/index.php">Bracelets</a>
            <a href="<?= $base_path ?>shop/categories/earrings/index.php">Earrings</a>
        </div>
    </header>

    <!-- Products Grid Container -->
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
                            <div class="home-product-meta"><?= e($prod->categoryName ?? 'Fine Jewellery') ?> &bull; handcrafted</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback when catalog products are loading -->
                <a href="<?= $base_path ?>shop/product/splash-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Splash Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Splash Golden Necklace</h3>
                        <div class="home-product-price">Rs. 28,500</div>
                        <div class="home-product-meta">necklaces &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/exuberant-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg" alt="Exuberant Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Exuberant Golden Necklace</h3>
                        <div class="home-product-price">Rs. 24,900</div>
                        <div class="home-product-meta">necklaces &bull; handcrafted</div>
                    </div>
                </a>
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
require_once __DIR__ . '/../includes/footer.php';
?>
