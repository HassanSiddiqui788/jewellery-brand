<?php
/**
 * Category: Necklaces – Lorem Ipsum
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Necklaces – Lorem Ipsum';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

$products = [
    [
        'title' => 'Exuberant golden Necklace',
        'price' => '$529.00',
        'image' => 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
        'url' => 'shop/product/exuberant-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ],
    [
        'title' => 'Meandres Golden Necklace',
        'price' => '$419.00',
        'image' => 'assets/images/2020/10/j3338co023200-2500.pw-270-420x583.jpg',
        'url' => 'shop/product/meandres-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ],
    [
        'title' => 'Moonrise Golden Necklace',
        'price' => '$369.00',
        'image' => 'assets/images/2020/10/j3284co063200.pw-1280-420x583.jpg',
        'url' => 'shop/product/moonrise-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ],
    [
        'title' => 'Nighwave Golden Necklace',
        'price' => '$369.00',
        'image' => 'assets/images/2020/10/j3370co053200.pw-1280-420x583.jpg',
        'url' => 'shop/product/nighwave-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ],
    [
        'title' => 'Portlligat Golden Necklace',
        'price' => '$319.00',
        'image' => 'assets/images/2020/10/j3378co023200.pw-1280-420x583.jpg',
        'url' => 'shop/product/portlligat-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ],
    [
        'title' => 'Splash Golden Necklace',
        'price' => '$369.00',
        'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/splash-golden-necklace/index.php',
        'tags' => ['golden', 'necklaces']
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Necklaces</h1>
        <p class="about-page-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
    </header>

    <div class="about-container" style="max-width: var(--site-max-width);">
        <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr);">
            <?php foreach ($products as $prod): ?>
                <a href="<?= $base_path ?><?= $prod['url'] ?>" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?><?= $prod['image'] ?>" alt="<?= htmlspecialchars($prod['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title"><?= htmlspecialchars($prod['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <div class="home-product-price"><?= htmlspecialchars($prod['price'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="home-product-meta"><?= implode(' &bull; ', $prod['tags']) ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
