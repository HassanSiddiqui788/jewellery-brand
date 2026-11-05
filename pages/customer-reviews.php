<?php
/**
 * Page: Customer Reviews – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Customer Reviews – Lorem Ipsum';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';

$reviews = [
    [
        'rating' => 5,
        'author' => 'Lorem Ipsum',
        'location' => 'Verified Buyer',
        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
        'date' => 'October 14, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Dolor Sit',
        'location' => 'Verified Buyer',
        'text' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia.',
        'date' => 'September 28, 2024'
    ],
    [
        'rating' => 4.5,
        'author' => 'Amet Consectetur',
        'location' => 'Verified Buyer',
        'text' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.',
        'date' => 'August 19, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Adipiscing Elit',
        'location' => 'Verified Buyer',
        'text' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.',
        'date' => 'July 05, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Tempor Incididunt',
        'location' => 'Verified Buyer',
        'text' => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam.',
        'date' => 'June 22, 2024'
    ],
    [
        'rating' => 5,
        'author' => 'Magna Aliqua',
        'location' => 'Verified Buyer',
        'text' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur quis autem vel eum iure reprehenderit.',
        'date' => 'May 30, 2024'
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Customer Reviews</h1>
        <p class="about-page-subtitle">Lorem Ipsum &bull; Consectetur Adipiscing &bull; Sed Do Eiusmod</p>
    </header>

    <div class="site-container" style="max-width: 1050px; padding: 0 24px 80px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            <?php foreach ($reviews as $review): ?>
                <div style="background: #ffffff; padding: 32px 28px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); box-shadow: 0 2px 12px rgba(0,0,0,0.03);">
                    <div style="color: var(--color-accent); font-size: 16px; margin-bottom: 12px;">
                        <?php 
                        $full_stars = floor($review['rating']);
                        for ($i = 0; $i < $full_stars; $i++) echo '★';
                        if ($review['rating'] - $full_stars >= 0.5) echo '★';
                        ?>
                    </div>
                    <p style="font-size: 15px; color: var(--color-text); line-height: 1.6; margin-bottom: 20px;">
                        &ldquo;<?= e($review['text']) ?>&rdquo;
                    </p>
                    <div style="border-top: 1px solid var(--color-border); padding-top: 14px; display: flex; justify-content: space-between; align-items: baseline;">
                        <strong style="color: var(--color-primary); font-family: var(--font-sans); font-size: 13px; text-transform: uppercase; letter-spacing: 1px;"><?= e($review['author']) ?></strong>
                        <span style="font-size: 12px; color: var(--color-muted);"><?= e($review['date']) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
