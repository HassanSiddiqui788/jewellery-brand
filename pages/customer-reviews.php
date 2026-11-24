<?php
/**
 * Page: Customer Reviews – JARWAYA JEWELS
 * Collector Reflections & Client Testimonials
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Customer Reviews – JARWAYA JEWELS';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';

$reviews = [
    [
        'rating' => 5,
        'author' => 'Sophia Rahman',
        'location' => 'Gulberg, Lahore',
        'text' => 'The craftsmanship of the Splash Golden Necklace is breathtaking. The weight feels substantial and luxurious, and the gold finish is radiant without being overly brassy. Exceptional presentation.',
        'date' => 'November 12, 2026'
    ],
    [
        'rating' => 5,
        'author' => 'Ayesha Tariq',
        'location' => 'Clifton, Karachi',
        'text' => 'My Miro Golden Bracelet has become an everyday signature piece. Subtle, architectural, and receives compliments whenever I wear it. Delivery was prompt and safely packaged.',
        'date' => 'October 28, 2026'
    ],
    [
        'rating' => 5,
        'author' => 'Mahnoor Khan',
        'location' => 'F-7, Islamabad',
        'text' => 'The Curves Golden Earrings exceeded every expectation. They catch the light effortlessly and are featherlight on the ears. Truly high-end jewellery artistry in Pakistan.',
        'date' => 'October 15, 2026'
    ],
    [
        'rating' => 5,
        'author' => 'Zainab Malik',
        'location' => 'DHA, Lahore',
        'text' => 'JARWAYA JEWELS sets a remarkable new standard for luxury fine jewellery. The velvet gift box and authenticity card make it feel like a treasured heirloom from day one.',
        'date' => 'September 22, 2026'
    ],
    [
        'rating' => 5,
        'author' => 'Hira Farooq',
        'location' => 'Saddar, Rawalpindi',
        'text' => 'Ordered the Exuberant Golden Necklace for an evening reception. The contours and polish are magnificent. Fast COD delivery and helpful concierge service on WhatsApp.',
        'date' => 'August 30, 2026'
    ],
    [
        'rating' => 5,
        'author' => 'Fatima Bilal',
        'location' => 'DHA Phase 6, Karachi',
        'text' => 'The Arquitectura Golden Bracelet is a true work of art. The hinge mechanism is sturdy and smooth. Highly recommend JARWAYA JEWELS to anyone who appreciates sculpted fine jewellery.',
        'date' => 'August 08, 2026'
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Collector Testimonials</h1>
        <p class="about-page-subtitle">Real experiences and reflections from JARWAYA JEWELS collectors across Pakistan.</p>
    </header>

    <div class="site-container" style="max-width: 1050px; padding: 0 24px 80px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px;">
            <?php foreach ($reviews as $rev): ?>
                <div style="background: #fff; border: 1px solid var(--color-border); border-radius: var(--radius-sm); padding: 32px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                    <div style="color: var(--color-accent); font-size: 16px; margin-bottom: 14px;">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <p style="font-size: 15px; color: var(--color-navy); line-height: 1.7; font-style: italic; margin-bottom: 20px;">
                        &ldquo;<?= htmlspecialchars($rev['text'], ENT_QUOTES, 'UTF-8') ?>&rdquo;
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0eee9; padding-top: 16px;">
                        <div>
                            <strong style="display: block; font-size: 14px; color: var(--color-navy);"><?= htmlspecialchars($rev['author'], ENT_QUOTES, 'UTF-8') ?></strong>
                            <span style="font-size: 12px; color: var(--color-muted);"><?= htmlspecialchars($rev['location'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <span style="font-size: 12px; color: var(--color-muted);"><?= htmlspecialchars($rev['date'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
