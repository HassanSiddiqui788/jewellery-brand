<?php
/**
 * Luxury Hero Slider Component
 * Matches Olight luxury jewellery showcase
 * Featuring revslider_1.jpg, revslider_2.jpg, revslider_3.jpg
 */
$base_path = $base_path ?? './';

$hero_slides = [
    [
        'image' => $base_path . 'assets/images/home-banner-images/revslider_1.jpg',
        'eyebrow' => 'PURELY HAND-CRAFTED',
        'title' => 'Charm For<br>Your Everyday',
        'desc' => 'Artisan handcrafted gold & diamond jewelry designed to elevate every moment.',
        'btn_text' => 'Shop Now',
        'btn_link' => $base_path . 'shop/index.php',
    ],
    [
        'image' => $base_path . 'assets/images/home-banner-images/revslider_2.jpg',
        'eyebrow' => 'TIMELESS BRILLIANCE',
        'title' => 'Radiance In<br>Every Detail',
        'desc' => 'Exquisite gemstone creations and fine diamond heirlooms sculpted with ethical precision.',
        'btn_text' => 'Discover Collections',
        'btn_link' => $base_path . 'shop/collections/index.php',
    ],
    [
        'image' => $base_path . 'assets/images/home-banner-images/revslider_3.jpg',
        'eyebrow' => 'NEW SEASON ARRIVALS',
        'title' => 'Golden Forms,<br>Natural Glow',
        'desc' => 'Sculptural organic silhouettes inspired by nature, light, and architectural grace.',
        'btn_text' => 'Explore Jewelry',
        'btn_link' => $base_path . 'shop/index.php',
    ],
];
?>

<section class="luxury-hero-section" aria-label="Hero Showcase">
    <div class="swiper luxury-hero-slider">
        <div class="swiper-wrapper">
            <?php foreach ($hero_slides as $index => $slide): ?>
                <div class="swiper-slide luxury-hero-slide" style="background-image: url('<?= htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8') ?>');">
                    <div class="luxury-hero-overlay"></div>
                    <div class="luxury-hero-container">
                        <div class="luxury-hero-caption">
                            <span class="luxury-hero-eyebrow"><?= htmlspecialchars($slide['eyebrow'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if ($index === 0): ?>
                                <h1 class="luxury-hero-title"><?= $slide['title'] ?></h1>
                            <?php else: ?>
                                <h2 class="luxury-hero-title"><?= $slide['title'] ?></h2>
                            <?php endif; ?>
                            <p class="luxury-hero-desc"><?= htmlspecialchars($slide['desc'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="luxury-hero-actions">
                                <a href="<?= htmlspecialchars($slide['btn_link'], ENT_QUOTES, 'UTF-8') ?>" class="luxury-hero-btn">
                                    <span><?= htmlspecialchars($slide['btn_text'], ENT_QUOTES, 'UTF-8') ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigation Controls -->
        <button class="swiper-button-prev luxury-hero-nav" aria-label="Previous Slide"></button>
        <button class="swiper-button-next luxury-hero-nav" aria-label="Next Slide"></button>

        <!-- Pagination Bullets -->
        <div class="swiper-pagination luxury-hero-pagination"></div>

        <!-- Scroll Indicator to #position1 -->
        <a href="#position1" class="luxury-hero-scroll" aria-label="Scroll to collection">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </a>
    </div>
</section>
