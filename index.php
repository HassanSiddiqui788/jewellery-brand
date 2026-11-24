<?php
/**
 * Page: Home – JARWAYA JEWELS
 * Exquisite Fine Jewellery & Modern Heirlooms
 */
require_once __DIR__ . '/includes/config.php';
$base_path = './';
$page_title = 'JARWAYA JEWELS – Exquisite Fine Jewellery & Modern Heirlooms';
$current_page = 'home';

$page_css = ['swiper.min.css', 'hero-banner.css', 'promo-banners.css'];
$page_scripts = ['swiper.min.js', 'hero-banner.js'];
require_once __DIR__ . '/includes/header.php';
?>

<!-- 1. Luxury Hero Banner Slider (Featuring revslider 1, 2, 3) -->
<?php include __DIR__ . '/includes/components/hero-slider.php'; ?>

<main id="main-content" class="site-main">
    <!-- 2. Dual Promotional Banners & Sliding Black Ribbon -->
    <?php include __DIR__ . '/includes/components/promo-dual-banner.php'; ?>

    <!-- 3. Selected Works / Featured Products Grid -->
    <?php
    $featured_products = get_catalog_products(null, 4);
    ?>
    <section id="position1" class="home-featured-section" aria-label="Featured Creations">
        <div class="home-section-header">
            <h2 class="home-section-heading">Featured Creations:</h2>
            <a href="<?= $base_path ?>shop/index.php" class="home-section-link">View All Jewellery &rarr;</a>
        </div>

        <div class="home-products-grid">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $prod): ?>
                    <a href="<?= $base_path ?>shop/product/<?= esc_attr($prod->slug) ?>/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?><?= esc_attr($prod->mainImage) ?>" 
                                 alt="<?= esc_attr($prod->name) ?>" 
                                 width="420" height="583" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title"><?= e($prod->name) ?></h3>
                            <div class="home-product-price"><?= format_price($prod->effectivePrice()) ?></div>
                            <div class="home-product-meta"><?= e($prod->categoryName ?? 'Jewellery') ?> &bull; handcrafted</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback when catalog products are loading -->
                <a href="<?= $base_path ?>shop/product/splash-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Splash Golden Necklace" width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Splash Golden Necklace</h3>
                        <div class="home-product-price">Rs. 28,500</div>
                        <div class="home-product-meta">necklaces &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/curves-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Curves Golden Earrings" width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Curves Golden Earrings</h3>
                        <div class="home-product-price">Rs. 14,500</div>
                        <div class="home-product-meta">earrings &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/portlligat-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Portlligat Golden Earrings" width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Portlligat Golden Earrings</h3>
                        <div class="home-product-price">Rs. 11,500</div>
                        <div class="home-product-meta">earrings &bull; handcrafted</div>
                    </div>
                </a>
                <a href="<?= $base_path ?>shop/product/miro-jewelry-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Miro Jewelry Golden Bracelet" width="420" height="381" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Miro Jewelry Golden Bracelet</h3>
                        <div class="home-product-price">Rs. 18,500</div>
                        <div class="home-product-meta">bracelets &bull; handcrafted</div>
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </section>

    <!-- 4. Editorial Split 1: Sculptural Grace -->
    <section class="home-editorial-split" aria-label="Featured Collection">
        <div class="editorial-row">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336605.jpg" 
                     alt="JARWAYA JEWELS Editorial" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Sculptural Grace<br>& Timeless Allure</h2>
                <p class="editorial-subtitle">Every piece is thoughtfully contoured with harmonious proportions and hand-finished brilliance.</p>
                <a href="<?= $base_path ?>shop/categories/necklaces/index.php" class="editorial-btn">
                    discover necklaces
                </a>
            </div>
        </div>

        <!-- 5. Editorial Split 2: Artisanal Mastery -->
        <div class="editorial-row reverse">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336598.jpg" 
                     alt="Artisanal Mastery" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Artisanal Mastery<br>& Modern Heirlooms</h2>
                <p class="editorial-subtitle">Crafted for discerning collectors who cherish understated opulence and enduring character.</p>
                <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                    explore collections
                </a>
            </div>
        </div>
    </section>

    <!-- 6. Collections Showcase Intro & Categories (Necklaces, Bracelets, Earrings) -->
    <section class="home-categories-section" aria-label="Product Categories">
        <div class="collections-watermark-wrap">
            <span class="collections-back-text" aria-hidden="true">collections</span>
            <div class="collections-hand-wrap">
                <img src="<?= $base_path ?>assets/images/2020/11/iStock-1164770941-Hand.png" 
                     alt="Artisan Jewelry Handcraft" 
                     class="home-hand-showcase" width="169" height="524" loading="lazy">
            </div>
        </div>
        <p class="home-quote-text">
            &ldquo;Jewellery that speaks with subtle grandeur&mdash;crafted with passion, shaped by heritage, and destined to be cherished forever.&rdquo;
        </p>

        <div class="categories-grid">
            <!-- Category 1: Necklaces -->
            <a href="<?= $base_path ?>shop/categories/necklaces/index.php" class="category-card" aria-label="Necklaces Collection">
                <div class="category-card-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/09/iStock-1030302600-necklaces_category-420x641.jpg" 
                         alt="Necklaces Collection" 
                         width="420" height="641" loading="lazy">
                </div>
                <div class="category-card-body">
                    <span class="category-card-letter">N</span>
                    <h3 class="category-card-title">Necklaces <span class="category-card-count">(2)</span></h3>
                </div>
            </a>

            <!-- Category 2: Bracelets -->
            <a href="<?= $base_path ?>shop/categories/bracelets/index.php" class="category-card" aria-label="Bracelets Collection">
                <div class="category-card-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" 
                         alt="Bracelets Collection" 
                         width="420" height="641" style="object-fit: cover;" loading="lazy">
                </div>
                <div class="category-card-body">
                    <span class="category-card-letter">B</span>
                    <h3 class="category-card-title">Bracelets <span class="category-card-count">(2)</span></h3>
                </div>
            </a>

            <!-- Category 3: Earrings -->
            <a href="<?= $base_path ?>shop/categories/earrings/index.php" class="category-card" aria-label="Earrings Collection">
                <div class="category-card-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/04/iStock-1153651611-Earrings-420x641.jpg" 
                         alt="Earrings Collection" 
                         width="420" height="641" loading="lazy">
                </div>
                <div class="category-card-body">
                    <span class="category-card-letter">E</span>
                    <h3 class="category-card-title">Earrings <span class="category-card-count">(2)</span></h3>
                </div>
            </a>
        </div>

        <div style="margin-top: 20px;">
            <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                explore collections
            </a>
        </div>
    </section>

    <!-- 7. Customer Testimonials -->
    <section class="home-testimonials-section" aria-label="Customer Testimonials">
        <div class="home-testimonials-container">
            <div class="home-testimonials-header">
                <h2 class="home-testimonials-title">What Our Clients Say</h2>
                <p class="home-testimonials-subtitle">Adorn Yourself in Glamour: Discover Real Collector Experiences</p>
            </div>

            <div class="home-testimonials-grid">
                <!-- Testimonial 1 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Sculptural Masterpiece &rdquo;</h3>
                    <p class="testimonial-text">
                        The craftsmanship of the Splash Golden Necklace is breathtaking. The radiant finish and substantial weight feel truly luxurious and timeless.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-1.jpg" alt="Sophia Rahman" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Sophia Rahman</strong>
                            <span class="testimonial-author-role">Lahore, Pakistan</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 2 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Understated Opulence &rdquo;</h3>
                    <p class="testimonial-text">
                        My Miro Golden Bracelet has become an everyday staple. Subtle, elegant, and turns heads at every dinner and gathering I attend.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-2.jpg" alt="Ayesha Tariq" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Ayesha Tariq</strong>
                            <span class="testimonial-author-role">Karachi, Pakistan</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 3 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Flawless Quality &rdquo;</h3>
                    <p class="testimonial-text">
                        Exceptional craftsmanship and swift insured delivery to Islamabad. The Curves Golden Earrings catch the light with unmatched radiance.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-3.jpg" alt="Mahnoor Khan" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Mahnoor Khan</strong>
                            <span class="testimonial-author-role">Islamabad, Pakistan</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 4 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Pure Luxury Distinction &rdquo;</h3>
                    <p class="testimonial-text">
                        JARWAYA JEWELS sets a new standard for luxury fine jewellery in Pakistan. Exquisite velvet packaging and true heirloom artistry.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-4.jpg" alt="Zainab Malik" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Zainab Malik</strong>
                            <span class="testimonial-author-role">Lahore, Pakistan</span>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- 8. Shop The Latest Trends Full-Width Banner -->
    <section class="home-trends-banner-section" style="background-image: url('<?= $base_path ?>assets/images/2024/h1_bn-6.jpg');" aria-label="Shop The Latest Trends">
        <div class="home-trends-banner-container">
            <div class="home-trends-banner-content">
                <span class="home-trends-eyebrow">JARWAYA COLLECTION</span>
                <h2 class="home-trends-title">Shop The Latest Trends</h2>
                <p class="home-trends-desc">
                    Exceptional Handcrafted Design to Enhance<br>the Magnificent Glow
                </p>
                <div class="home-trends-action">
                    <a href="<?= $base_path ?>shop/index.php" class="home-trends-btn">Shop Now</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
