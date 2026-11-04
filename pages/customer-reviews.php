<?php
/**
 * Page: Customer Reviews – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Customer Reviews – Bijoux';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';

$reviews = [
    [
        'rating' => 5,
        'author' => 'Emily Alvarado',
        'location' => 'Verified Buyer',
        'text' => 'This was an amazing buy. It was just as described and the customer service was just as amazing as the buy. I will definitely be returning soon!',
        'date' => 'October 14, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Elane Miller',
        'location' => 'Verified Buyer',
        'text' => 'In love with my new earrings! The only downside is that I only own one pair… for now 😉 Can’t wait to get my next heirloom piece.',
        'date' => 'September 28, 2024'
    ],
    [
        'rating' => 4.5,
        'author' => 'Randy Lyons',
        'location' => 'Verified Buyer',
        'text' => 'Couldn’t be happier with the craftsmanship! Enjoy wearing it often. The gold finish has held up impeccably and always draws compliments.',
        'date' => 'August 19, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Sasha Jones',
        'location' => 'Verified Buyer',
        'text' => 'The modular versatility is genuine genius. I wore my necklace to an evening gala as a bold statement, and transformed it into a chic bracelet the next day.',
        'date' => 'July 05, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Victoria Chang',
        'location' => 'Verified Buyer',
        'text' => 'Exceptional craftsmanship and ethical sourcing. You can feel the weight and precision of authentic artisan work the second you hold it.',
        'date' => 'June 22, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Clara Vance',
        'location' => 'Verified Buyer',
        'text' => 'My partner gifted me the Blossom golden bracelet for our anniversary. It is beyond stunning and so comfortable for everyday wear.',
        'date' => 'May 11, 2024'
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Customer Reviews</h1>
        <p class="about-page-subtitle">Rated 4.9 / 5.0 by our beloved collectors worldwide</p>
    </header>

    <div class="about-container">
        <!-- Average Rating Summary Card -->
        <div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 4px; padding: 35px 25px; text-align: center; max-width: 500px; margin: 0 auto 50px auto; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);">
            <div style="font-family: var(--font-serif); font-size: 52px; font-weight: 500; color: var(--color-primary); line-height: 1;">4.9</div>
            <div style="color: #e5a93b; font-size: 18px; margin: 10px 0 6px 0;">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p style="font-family: var(--font-sans); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--color-muted); margin: 0;">
                Based on 34 Verified Collector Reviews
            </p>
        </div>

        <!-- Reviews Grid -->
        <section class="reviews-grid" aria-label="Customer Reviews List">
            <?php foreach ($reviews as $rev): ?>
                <article class="review-card">
                    <div>
                        <div class="review-stars">
                            <?php for ($i = 0; $i < floor($rev['rating']); $i++): ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                            <?php if ($rev['rating'] - floor($rev['rating']) >= 0.5): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php endif; ?>
                        </div>
                        <p class="review-text">&ldquo;<?= htmlspecialchars($rev['text'], ENT_QUOTES, 'UTF-8') ?>&rdquo;</p>
                    </div>
                    <div>
                        <div class="review-author"><?= htmlspecialchars($rev['author'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="review-verified">
                            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($rev['location'], ENT_QUOTES, 'UTF-8') ?> &bull; <?= htmlspecialchars($rev['date'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <!-- CTA Callout -->
        <div style="text-align: center; margin-top: 60px; padding: 40px; background: var(--color-cream); border-radius: 4px;">
            <h3 style="font-family: var(--font-serif); font-size: 28px; margin: 0 0 10px 0; color: var(--color-primary);">Discover Why Our Collectors Love Bijoux</h3>
            <p style="color: var(--color-muted); font-size: 15px; margin: 0 0 25px 0;">Explore timeless creations crafted with authentic gold and sustainably sourced gemstones.</p>
            <a href="<?= $base_path ?>shop/index.php" class="editorial-btn">
                Shop The Collection
            </a>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
