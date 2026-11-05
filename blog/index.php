<?php
/**
 * Page: Journal & Blog – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Journal & Blog – Lorem Ipsum';
$current_page = 'journal';

require_once __DIR__ . '/../includes/header.php';

$posts = [
    [
        'title' => 'Lorem Ipsum: 5 Steps to Reawaken Inspiration',
        'url' => 'blog/posts/the-creative-journey-5-steps-to-reawaken-inspiration/index.php',
        'image' => 'assets/images/2020/04/tamara-bellis-nbC4EyCxhb8-unsplash-1024x683.jpg',
        'excerpt' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.',
        'category' => 'Inspiration &bull; Tips'
    ],
    [
        'title' => 'Consectetur Adipiscing: In Honor of Autumn',
        'url' => 'blog/posts/introducing-the-beautiful-you-in-honor-of-autism-awareness/index.php',
        'image' => 'assets/images/2020/04/brooke-cagle-kElEigko7PU-unsplash-1024x630.jpg',
        'excerpt' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.',
        'category' => 'Spotlight'
    ],
    [
        'title' => 'The Inspiration Behind The Universal Collection',
        'url' => 'blog/posts/the-inspiration-behind-the-universal-strength-collection/index.php',
        'image' => 'assets/images/2020/04/rashid-khreiss-My2R_GyYnvg-unsplash-1024x630.jpg',
        'excerpt' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo.',
        'category' => 'Design &bull; Heritage'
    ],
    [
        'title' => 'Inspiration Behind the New Collection',
        'url' => 'blog/posts/inspiration-behind-the-new-chakras-collection/index.php',
        'image' => 'assets/images/2020/04/carmen-lopez-oeFneUxJya4-unsplash-706x1024.jpg',
        'excerpt' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem.',
        'category' => 'Gemstones'
    ],
    [
        'title' => 'Holiday Inspiration: The Night Sky',
        'url' => 'blog/posts/holiday-inspiration-the-night-sky/index.php',
        'image' => 'assets/images/2020/04/wu-yi-1eLUs_frRpU-unsplash-1024x630.jpg',
        'excerpt' => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt.',
        'category' => 'Inspiration'
    ],
    [
        'title' => 'End of Year Reflections',
        'url' => 'blog/posts/end-of-year-reflections/index.php',
        'image' => 'assets/images/2020/04/andreea-ch-sg04qE6u5kU-unsplash-1024x683.jpg',
        'excerpt' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur.',
        'category' => 'Journal'
    ]
];
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Journal &amp; Editorial</h1>
        <p class="about-page-subtitle">Lorem Ipsum &bull; Consectetur Adipiscing &bull; Sed Do Eiusmod</p>
    </header>

    <div class="site-container" style="max-width: 1100px; padding: 0 24px 80px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
            <?php foreach ($posts as $post): ?>
                <article style="background: #ffffff; border: 1px solid var(--color-border); border-radius: var(--radius-sm); overflow: hidden; display: flex; flex-direction: column;">
                    <div style="aspect-ratio: 16/10; overflow: hidden; background: var(--color-cream);">
                        <img src="<?= $base_path . e($post['image']) ?>" alt="<?= e($post['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 24px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--color-accent); font-weight: 600; display: block; margin-bottom: 8px;">
                                <?= $post['category'] ?>
                            </span>
                            <h2 style="font-size: 20px; font-weight: 400; line-height: 1.35; margin: 0 0 12px 0;">
                                <a href="<?= site_url($post['url'], $base_path) ?>" style="color: var(--color-primary);"><?= e($post['title']) ?></a>
                            </h2>
                            <p style="font-size: 14px; color: var(--color-muted); line-height: 1.6; margin: 0 0 16px 0;">
                                <?= e($post['excerpt']) ?>
                            </p>
                        </div>
                        <a href="<?= site_url($post['url'], $base_path) ?>" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: var(--color-primary);">Read Article &rarr;</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
