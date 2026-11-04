<?php
/**
 * Category: Gift Cards – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Gift Cards – Bijoux';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

$products = [
    [
        'title' => 'Digital Gift Card – Tier 1',
        'price' => '$50.00 – $500.00',
        'image' => 'assets/images/2020/11/gift_card_01-420x583.jpg',
        'url' => 'shop/product/gift-card/index.php',
        'tags' => ['gift-card']
    ],
    [
        'title' => 'Luxury Gift Card – Tier 2',
        'price' => '$100.00 – $1,000.00',
        'image' => 'assets/images/2020/11/gift_card_02-420x420.jpg',
        'url' => 'shop/product/gift-card-2/index.php',
        'tags' => ['gift-card']
    ],
    [
        'title' => 'Artisan Gift Card – Tier 3',
        'price' => '$250.00 – $2,500.00',
        'image' => 'assets/images/2020/11/gift_card_01-420x583.jpg',
        'url' => 'shop/product/gift-card-3/index.php',
        'tags' => ['gift-card']
    ],
    [
        'title' => 'Collector Gift Card – Tier 4',
        'price' => '$500.00 – $5,000.00',
        'image' => 'assets/images/2020/11/gift_card_02-420x420.jpg',
        'url' => 'shop/product/gift-card-4/index.php',
        'tags' => ['gift-card']
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Gift Cards</h1>
        <p class="about-page-subtitle">Give the gift of timeless luxury and artisanal beauty</p>
    </header>

    <div class="about-container" style="max-width: var(--site-max-width);">
        <div class="home-products-grid" style="grid-template-columns: repeat(4, 1fr);">
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
