<?php
/**
 * Page: Home – Lorem Ipsum
 * Lorem Ipsum Store
 */
require_once __DIR__ . '/includes/config.php';
$base_path = './';
$page_title = 'Home – Lorem Ipsum';
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
    <section id="position1" class="home-featured-section" aria-label="Selected Works">
        <div class="home-section-header">
            <h2 class="home-section-heading">Lorem Ipsum:</h2>
            <a href="<?= $base_path ?>shop/index.php" class="home-section-link">Lorem Ipsum &rarr;</a>
        </div>

        <div class="home-products-grid">
            <!-- Product 1: Splash Golden Necklace -->
            <a href="<?= $base_path ?>shop/product/splash-golden-necklace/index.php" class="home-product-card">
                <div class="home-product-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" 
                         alt="Splash Golden Necklace" 
                         width="420" height="583" loading="lazy">
                </div>
                <div class="home-product-info">
                    <h3 class="home-product-title">Splash Golden Necklace</h3>
                    <div class="home-product-price">&#36;369.00</div>
                    <div class="home-product-meta">golden &bull; necklaces</div>
                </div>
            </a>

            <!-- Product 2: Curves Golden Earrings -->
            <a href="<?= $base_path ?>shop/product/curves-golden-earrings/index.php" class="home-product-card">
                <div class="home-product-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" 
                         alt="Curves Golden Earrings" 
                         width="420" height="583" loading="lazy">
                </div>
                <div class="home-product-info">
                    <h3 class="home-product-title">Curves Golden Earrings</h3>
                    <div class="home-product-price">&#36;189.00</div>
                    <div class="home-product-meta">golden &bull; earrings</div>
                </div>
            </a>

            <!-- Product 3: Portlligat Golden Earrings -->
            <a href="<?= $base_path ?>shop/product/portlligat-golden-earrings/index.php" class="home-product-card">
                <div class="home-product-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" 
                         alt="Portlligat Golden Earrings" 
                         width="420" height="583" loading="lazy">
                </div>
                <div class="home-product-info">
                    <h3 class="home-product-title">Portlligat Golden Earrings</h3>
                    <div class="home-product-price">&#36;119.00</div>
                    <div class="home-product-meta">earrings &bull; golden</div>
                </div>
            </a>

            <!-- Product 4: Miro Jewelry Golden Bracelet -->
            <a href="<?= $base_path ?>shop/product/miro-jewelry-golden-bracelet/index.php" class="home-product-card">
                <div class="home-product-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" 
                         alt="Miro Jewelry Golden Bracelet" 
                         width="420" height="381" loading="lazy">
                </div>
                <div class="home-product-info">
                    <h3 class="home-product-title">Miro Jewelry Golden Bracelet</h3>
                    <div class="home-product-price">&#36;219.00</div>
                    <div class="home-product-meta">bracelet &bull; golden</div>
                </div>
            </a>
        </div>
    </section>

    <!-- 4. Editorial Split 1: Lorem Ipsum Dolor -->
    <section class="home-editorial-split" aria-label="Featured Collection">
        <div class="editorial-row">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336605.jpg" 
                     alt="Lorem Ipsum Editorial" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Lorem Ipsum<br>Dolor Sit Amet</h2>
                <p class="editorial-subtitle">consectetur adipiscing elit sed do eiusmod tempor.</p>
                <a href="<?= $base_path ?>shop/collections/index.php#necklaces" class="editorial-btn">
                    discover
                </a>
            </div>
        </div>

        <!-- 5. Editorial Split 2: Sed Do Eiusmod -->
        <div class="editorial-row reverse">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336598.jpg" 
                     alt="Consectetur Adipiscing" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Sed Do Eiusmod<br>Tempor Incididunt</h2>
                <p class="editorial-subtitle">ut enim ad minim veniam quis nostrud exercitation.</p>
                <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                    discover the set
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
            Lorem ipsum dolor sit amet, consectetur adipiscing elit,<br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua&hellip;
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
                    <h3 class="category-card-title">Necklaces <span class="category-card-count">(6)</span></h3>
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
                    <h3 class="category-card-title">Bracelets <span class="category-card-count">(6)</span></h3>
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
                    <h3 class="category-card-title">Earrings <span class="category-card-count">(6)</span></h3>
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
                <p class="home-testimonials-subtitle">Adorn Yourself in Glamour: Find Your Perfect Piece Today</p>
            </div>

            <div class="home-testimonials-grid">
                <!-- Testimonial 1 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Golden Bracelets &rdquo;</h3>
                    <p class="testimonial-text">
                        Montluc claim to offer the finest diamond jewellery . I did my research, compared with some of the big brands and now I will never walk into a store again.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-1.jpg" alt="Rose Ether" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Rose Ether</strong>
                            <span class="testimonial-author-role">Fresh Design</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 2 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Charming Golden Jewellery &rdquo;</h3>
                    <p class="testimonial-text">
                        I did my research, compared with some of the big brands and now Aenean pulvinar maximus. Montluc claim to offer the finest diamond jewellery you can buy direct from the maker.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-2.jpg" alt="Clara Weton" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Clara Weton</strong>
                            <span class="testimonial-author-role">Fresh Design</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 3 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Charming Golden Jewellery &rdquo;</h3>
                    <p class="testimonial-text">
                        Integer nunc viverra laoreet est the is porta pretium metus aliquam eget maecenas porta is nunc viverra Aenean pulvinar maximus. Consectetur adipiscing elit.
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-3.jpg" alt="Seraton Suth" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Seraton Suth</strong>
                            <span class="testimonial-author-role">Fresh Design</span>
                        </div>
                    </div>
                </article>

                <!-- Testimonial 4 -->
                <article class="home-testimonial-card">
                    <div class="testimonial-stars" aria-label="5 out of 5 stars">
                        &#9733;&#9733;&#9733;&#9733;&#9733;
                    </div>
                    <h3 class="testimonial-quote-title">&ldquo; Charming Golden Jewellery &rdquo;</h3>
                    <p class="testimonial-text">
                        Consectetur adipiscing elit. Integer nunc viverra laoreet est the is porta pretium metus aliquam eget maecenas porta is nunc viverra Aenean pulvinar maximus
                    </p>
                    <div class="testimonial-author">
                        <img src="<?= $base_path ?>assets/images/testimonials/avatar-4.jpg" alt="Alex Rony" class="testimonial-avatar" width="36" height="36" loading="lazy">
                        <div class="testimonial-author-meta">
                            <strong class="testimonial-author-name">Alex Rony</strong>
                            <span class="testimonial-author-role">Fresh Design</span>
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
                <span class="home-trends-eyebrow">OLIGHT COLLECTION</span>
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
