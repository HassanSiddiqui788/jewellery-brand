<?php
/**
 * Page: Shop All Jewelry – Lorem Ipsum
 * Luxury Jewelry Catalog
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shop All Jewelry – Lorem Ipsum';
$body_class = 'archive post-type-archive post-type-archive-product page-shop';
$current_page = 'collections';

require_once __DIR__ . '/../includes/header.php';

$all_products = [
    // --- Necklaces ---
    [
        'title' => 'Exuberant Golden Necklace',
        'price' => '$349.00',
        'image' => 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
        'url' => 'shop/product/exuberant-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],
    [
        'title' => 'Moonrise Golden Necklace',
        'price' => '$299.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/moonrise-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],
    [
        'title' => 'Portlligat Golden Necklace',
        'price' => '$279.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/portlligat-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],
    [
        'title' => 'Nightwave Golden Necklace',
        'price' => '$320.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/nighwave-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],
    [
        'title' => 'Meandres Golden Necklace',
        'price' => '$265.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/meandres-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],
    [
        'title' => 'Splash Golden Necklace',
        'price' => '$369.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/splash-golden-necklace/index.php',
        'meta' => 'golden &bull; necklaces'
    ],

    // --- Bracelets ---
    [
        'title' => 'Miro Jewelry Golden Bracelet',
        'price' => '$219.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/miro-jewelry-golden-bracelet/index.php',
        'meta' => 'bracelet &bull; golden'
    ],
    [
        'title' => 'Arquitectura Golden Bracelet',
        'price' => '$280.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/arquitectura-golden-bracelet-copy/index.php',
        'meta' => 'bracelet &bull; golden'
    ],
    [
        'title' => 'Portlligat Golden Bracelet',
        'price' => '$195.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/portlligat-golden-bracelet/index.php',
        'meta' => 'bracelet &bull; golden'
    ],
    [
        'title' => 'Blush Golden Bracelet',
        'price' => '$240.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/blush-golden-bracelet/index.php',
        'meta' => 'bracelet &bull; golden'
    ],
    [
        'title' => 'Blossom Golden Bracelet',
        'price' => '$260.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/blossom-golden-bracelet/index.php',
        'meta' => 'bracelet &bull; golden'
    ],
    [
        'title' => 'Olivia Golden Bracelet',
        'price' => '$225.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/olivia-golden-bracelet/index.php',
        'meta' => 'bracelet &bull; golden'
    ],

    // --- Earrings ---
    [
        'title' => 'Arquitectura Golden Earrings',
        'price' => '$245.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/arquitectura-golden-earrings/index.php',
        'meta' => 'earrings &bull; golden'
    ],
    [
        'title' => 'Curves Golden Earrings',
        'price' => '$195.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/curves-golden-earrings/index.php',
        'meta' => 'earrings &bull; golden'
    ],
    [
        'title' => 'Portlligat Golden Earrings',
        'price' => '$119.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/portlligat-golden-earrings/index.php',
        'meta' => 'earrings &bull; golden'
    ],
    [
        'title' => 'Angel Hoops',
        'price' => '$189.00',
        'image' => 'assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg',
        'url' => 'shop/product/angel-hoops/index.php',
        'meta' => 'earrings &bull; golden'
    ],
    [
        'title' => 'Esplendida Golden Earrings',
        'price' => '$215.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/esplendida-golden-earrings/index.php',
        'meta' => 'earrings &bull; golden'
    ],
    [
        'title' => 'Carla Golden Earrings',
        'price' => '$175.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/carla-golden-earrings/index.php',
        'meta' => 'earrings &bull; golden'
    ],
];
?>

<main id="main-content" class="site-main">
    <!-- Luxury Page Header -->
    <header class="about-page-header">
        <h1 class="about-page-title">Lorem Ipsum Catalog</h1>
        <p class="about-page-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        
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
        <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr);">
            <?php foreach ($all_products as $product): ?>
                <a href="<?= $base_path ?><?= $product['url'] ?>" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?><?= $product['image'] ?>" alt="<?= htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title"><?= htmlspecialchars($product['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <div class="home-product-price"><?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="home-product-meta"><?= $product['meta'] ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
