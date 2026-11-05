<?php
/**
 * Category: Bracelets – Lorem Ipsum
 */
require_once __DIR__ . '/../../../includes/config.php';
$base_path = '../../../';
$page_title = 'Bracelets – Lorem Ipsum';
$current_page = 'collections';

require_once __DIR__ . '/../../../includes/header.php';

$products = [
    [
        'title' => 'Arquitectura Golden Bracelet',
        'price' => '$280.00',
        'image' => 'assets/images/2020/10/j3371po033200.pw-1280-420x381.jpg',
        'url' => 'shop/product/arquitectura-golden-bracelet-copy/index.php',
        'tags' => ['bracelet', 'golden']
    ],
    [
        'title' => 'Blossom Golden Bracelet',
        'price' => '$260.00',
        'image' => 'assets/images/2020/09/j3370po013200.pw-1280-420x381.jpg',
        'url' => 'shop/product/blossom-golden-bracelet/index.php',
        'tags' => ['bracelet', 'golden']
    ],
    [
        'title' => 'Blush Golden Bracelet',
        'price' => '$240.00',
        'image' => 'assets/images/2020/10/j3376po043200.pw-1280-420x381.jpg',
        'url' => 'shop/product/blush-golden-bracelet/index.php',
        'tags' => ['bracelet', 'golden']
    ],
    [
        'title' => 'Miro Jewelry Golden Bracelet',
        'price' => '$219.00',
        'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
        'url' => 'shop/product/miro-jewelry-golden-bracelet/index.php',
        'tags' => ['bracelet', 'golden']
    ],
    [
        'title' => 'Olivia Golden Bracelet',
        'price' => '$225.00',
        'image' => 'assets/images/2020/01/j3354po053200.pw-1280-420x381.jpg',
        'url' => 'shop/product/olivia-golden-bracelet/index.php',
        'tags' => ['bracelet', 'golden']
    ],
    [
        'title' => 'Portlligat Golden Bracelet',
        'price' => '$195.00',
        'image' => 'assets/images/2020/10/j3378po023200.pw-1280-420x381.jpg',
        'url' => 'shop/product/portlligat-golden-bracelet/index.php',
        'tags' => ['bracelet', 'golden']
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Bracelets</h1>
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
