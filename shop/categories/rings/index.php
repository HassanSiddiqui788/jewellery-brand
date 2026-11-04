<?php
/**
 * Category: Rings – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Rings – Bijoux';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

$products = [
    [
        'title' => 'Bliss Golden Ring',
        'price' => '$229.00',
        'image' => 'assets/images/2020/07/j3334an0132-correcte.pw-1280-1-420x381.jpg',
        'url' => 'shop/product/bliss-golden-ring/index.php',
        'tags' => ['golden', 'ring']
    ],
    [
        'title' => 'Carla Golden Ring',
        'price' => '$185.00',
        'image' => 'assets/images/2020/03/j3343an0232-2500.pw-1280-420x381.jpg',
        'url' => 'shop/product/carla-golden-ring/index.php',
        'tags' => ['golden', 'ring']
    ],
    [
        'title' => 'Curves Golden Ring',
        'price' => '$210.00',
        'image' => 'assets/images/2020/10/j3374an0132.pw-1280-420x381.jpg',
        'url' => 'shop/product/curves-golden-ring/index.php',
        'tags' => ['golden', 'ring']
    ],
    [
        'title' => 'Exuberant Golden Ring',
        'price' => '$245.00',
        'image' => 'assets/images/2020/10/j3376an0132.pw-1280-420x381.jpg',
        'url' => 'shop/product/exuberant-golden-ring/index.php',
        'tags' => ['golden', 'ring']
    ],
    [
        'title' => 'Magnolia Golden Ring',
        'price' => '$199.00',
        'image' => 'assets/images/2020/10/j3301an0232-app.pw-1280-420x381.jpg',
        'url' => 'shop/product/magnolia-golden-ring/index.php',
        'tags' => ['golden', 'ring']
    ],
    [
        'title' => 'Monochrome Ring',
        'price' => '$229.00',
        'image' => 'assets/images/2020/09/j3368an0132.pw-1280-420x381.jpg',
        'url' => 'shop/product/monochrome/index.php',
        'tags' => ['golden', 'ring']
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Rings</h1>
        <p class="about-page-subtitle">Showing all 6 handcrafted gold &amp; diamond ring creations</p>
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
