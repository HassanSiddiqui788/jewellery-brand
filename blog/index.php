<?php
/**
 * Page: Journal & Blog – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Journal & Blog – Bijoux';
$current_page = 'journal';

require_once __DIR__ . '/../includes/header.php';

$posts = [
    [
        'title' => 'The Creative Journey: 5 Steps to Reawaken Inspiration',
        'url' => 'blog/posts/the-creative-journey-5-steps-to-reawaken-inspiration/index.php',
        'image' => 'assets/images/2020/04/tamara-bellis-nbC4EyCxhb8-unsplash-1024x683.jpg',
        'excerpt' => 'The journey to creative inspiration can be an infinitely fulfilling one. When we are in alignment and our creativity is flowing, it seems as if the world unfolds before us.',
        'category' => 'Inspiration &bull; Tips'
    ],
    [
        'title' => 'Introducing ‘The Beautiful You’: In Honor of Autism Awareness',
        'url' => 'blog/posts/introducing-the-beautiful-you-in-honor-of-autism-awareness/index.php',
        'image' => 'assets/images/2020/04/brooke-cagle-kElEigko7PU-unsplash-1024x630.jpg',
        'excerpt' => 'Celebrating individuality and radiant beauty with our exclusive charitable capsule collection dedicated to community and awareness.',
        'category' => 'Spotlight'
    ],
    [
        'title' => 'The Inspiration Behind The Universal Strength Collection',
        'url' => 'blog/posts/the-inspiration-behind-the-universal-strength-collection/index.php',
        'image' => 'assets/images/2020/04/rashid-khreiss-My2R_GyYnvg-unsplash-1024x630.jpg',
        'excerpt' => 'Discover the architectural curves and historical inspirations behind our boldest and most empowering gold jewelry collection to date.',
        'category' => 'Design &bull; Heritage'
    ],
    [
        'title' => 'Inspiration Behind the New Chakras Collection',
        'url' => 'blog/posts/inspiration-behind-the-new-chakras-collection/index.php',
        'image' => 'assets/images/2020/04/carmen-lopez-oeFneUxJya4-unsplash-706x1024.jpg',
        'excerpt' => 'Harnessing the natural energy of gemstones and sacred geometry to craft daily talismans of balance and inner serenity.',
        'category' => 'Gemstones'
    ],
    [
        'title' => 'Holiday Inspiration: The Night Sky',
        'url' => 'blog/posts/holiday-inspiration-the-night-sky/index.php',
        'image' => 'assets/images/2020/04/wu-yi-1eLUs_frRpU-unsplash-1024x630.jpg',
        'excerpt' => 'From celestial constellations to shimmering diamond clusters, explore our guide to styling celestial jewelry for festive celebrations.',
        'category' => 'Style Guide'
    ],
    [
        'title' => 'End of Year Reflections',
        'url' => 'blog/posts/end-of-year-reflections/index.php',
        'image' => 'assets/images/2020/09/image_68_v2-1024x763.jpg',
        'excerpt' => 'A heartfelt look back on the moments, milestones, and sustainable initiatives that shaped our studio this past year.',
        'category' => 'Journal'
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">The Bijoux Journal</h1>
        <p class="about-page-subtitle">Stories of craftsmanship, sustainable materials, and timeless aesthetic inspiration</p>
    </header>

    <div class="about-container" style="max-width: var(--site-max-width);">
        <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr); gap: 40px;">
            <?php foreach ($posts as $post): ?>
                <article class="home-product-card" style="text-align: left;">
                    <a href="<?= $base_path ?><?= $post['url'] ?>" class="home-product-thumb" style="aspect-ratio: 16/10;">
                        <img src="<?= $base_path ?><?= $post['image'] ?>" alt="<?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
                    </a>
                    <div class="home-product-info" style="text-align: left; padding: 24px;">
                        <span style="font-family: var(--font-sans); font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; color: var(--color-accent); margin-bottom: 8px; display: block;">
                            <?= $post['category'] ?>
                        </span>
                        <h2 style="font-family: var(--font-serif); font-size: 20px; font-weight: 400; line-height: 1.35; color: var(--color-primary); margin: 0 0 12px 0;">
                            <a href="<?= $base_path ?><?= $post['url'] ?>" style="color: inherit; text-decoration: none;">
                                <?= htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h2>
                        <p style="font-size: 14px; line-height: 1.6; color: var(--color-muted); margin: 0 0 18px 0;">
                            <?= htmlspecialchars($post['excerpt'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <a href="<?= $base_path ?><?= $post['url'] ?>" style="font-family: var(--font-sans); font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--color-primary); text-decoration: none;">
                            Read Story &rarr;
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
