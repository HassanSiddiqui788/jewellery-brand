<?php
/**
 * Category: Earrings – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Earrings – Bijoux';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

$products = [
    [
        'title' => 'Angel Hoops Golden Earrings',
        'price' => '$189.00',
        'image' => 'assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg',
        'url' => 'shop/product/angel-hoops/index.php',
        'tags' => ['earrings', 'golden']
    ],
    [
        'title' => 'Arquitectura Golden Earrings',
        'price' => '$245.00',
        'image' => 'assets/images/2020/10/j3371ar033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/arquitectura-golden-earrings/index.php',
        'tags' => ['earrings', 'golden']
    ],
    [
        'title' => 'Carla Golden Earrings',
        'price' => '$175.00',
        'image' => 'assets/images/2020/05/iStock-523356255-420x583.jpg',
        'url' => 'shop/product/carla-golden-earrings/index.php',
        'tags' => ['earrings', 'golden']
    ],
    [
        'title' => 'Curves Golden Earrings',
        'price' => '$195.00',
        'image' => 'assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg',
        'url' => 'shop/product/curves-golden-earrings/index.php',
        'tags' => ['earrings', 'golden']
    ],
    [
        'title' => 'Esplendida Golden Earrings',
        'price' => '$215.00',
        'image' => 'assets/images/2020/09/j3368ar033200.pw-1280-420x583.jpg',
        'url' => 'shop/product/esplendida-golden-earrings/index.php',
        'tags' => ['earrings', 'golden']
    ],
    [
        'title' => 'Portlligat Golden Earrings',
        'price' => '$119.00',
        'image' => 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
        'url' => 'shop/product/portlligat-golden-earrings/index.php',
        'tags' => ['earrings', 'golden']
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Earrings</h1>
        <p class="about-page-subtitle">Showing all 6 handcrafted gold &amp; diamond earring creations</p>
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
