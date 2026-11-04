<?php
/**
 * Page: Home – Bijoux Artisan Handcrafted Jewelry
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/includes/config.php';
$base_path = './';
$page_title = 'Bijoux – Artisan Handcrafted Jewelry';
$current_page = 'home';

$page_css = ['swiper.min.css', 'hero-banner.css'];
$page_scripts = ['swiper.min.js', 'hero-banner.js'];
require_once __DIR__ . '/includes/header.php';
?>

<!-- 1. Luxury Hero Banner Slider (Featuring revslider 1, 2, 3) -->
<?php include __DIR__ . '/includes/components/hero-slider.php'; ?>

<main id="main-content" class="site-main">
    <!-- 2. Brand Mission Statement -->
    <section class="home-statement-section" aria-label="Brand Philosophy">
        <p class="home-statement-text">
            It has always been to produce awesome products for the dynamic urban lifestyle of the modern woman.
        </p>
        <a href="<?= $base_path ?>pages/about.php" class="home-story-btn">
            Our Story
        </a>
    </section>

    <!-- 3. Selected Works / Featured Products Grid -->
    <section id="position1" class="home-featured-section" aria-label="Selected Works">
        <div class="home-section-header">
            <h2 class="home-section-heading">Selected works:</h2>
            <a href="<?= $base_path ?>shop/index.php" class="home-section-link">View All Catalog &rarr;</a>
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

            <!-- Product 2: Monochrome Ring -->
            <a href="<?= $base_path ?>shop/product/monochrome/index.php" class="home-product-card">
                <div class="home-product-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/09/j3368an0132.pw-1280-420x381.jpg" 
                         alt="Monochrome Ring" 
                         width="420" height="381" loading="lazy">
                </div>
                <div class="home-product-info">
                    <h3 class="home-product-title">Monochrome Ring</h3>
                    <div class="home-product-price">&#36;229.00</div>
                    <div class="home-product-meta">golden &bull; ring</div>
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

    <!-- 4. Editorial Split 1: Antique Diamond Necklaces -->
    <section class="home-editorial-split" aria-label="Featured Collection">
        <div class="editorial-row">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336605.jpg" 
                     alt="Antique Diamond Necklaces Editorial" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Antique<br>Diamond Necklaces</h2>
                <p class="editorial-subtitle">beautiful colors. excellent quality.</p>
                <a href="<?= $base_path ?>shop/collections/index.php#necklaces" class="editorial-btn">
                    discover
                </a>
            </div>
        </div>

        <!-- 5. Editorial Split 2: Perfect Match for Every Occasion -->
        <div class="editorial-row reverse">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/05/iStock-1136336598.jpg" 
                     alt="Perfect Match for Every Occasion" 
                     width="1070" height="1552" loading="lazy">
            </div>
            <div class="editorial-content">
                <h2 class="editorial-title">Perfect Match<br>for Every Occasion</h2>
                <p class="editorial-subtitle">coordinate with other pieces from the collection for a classic look.</p>
                <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                    discover the set
                </a>
            </div>
        </div>
    </section>

    <!-- 6. Collections Showcase Intro & Categories -->
    <section class="home-categories-section" aria-label="Product Categories">
        <img src="<?= $base_path ?>assets/images/2020/11/iStock-1164770941-Hand.png" 
             alt="Artisan Jewelry Handcraft" 
             class="home-hand-icon" width="169" height="524" loading="lazy">
        <p class="home-quote-text">
            Inspired by our multi-ethnic life,<br>we create fine jewelry to share our wonderful tales&hellip;
        </p>

        <div class="categories-grid">
            <!-- Category 1: Rings -->
            <a href="<?= $base_path ?>shop/categories/rings/index.php" class="category-card" aria-label="Rings Collection">
                <div class="category-card-thumb">
                    <img src="<?= $base_path ?>assets/images/2020/09/iStock-1153651470-rings_category-420x641.jpg" 
                         alt="Rings Collection" 
                         width="420" height="641" loading="lazy">
                </div>
                <div class="category-card-body">
                    <span class="category-card-letter">R</span>
                    <h3 class="category-card-title">Rings <span class="category-card-count">(6)</span></h3>
                </div>
            </a>

            <!-- Category 2: Earrings -->
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

            <!-- Category 3: Necklaces -->
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
        </div>

        <div style="margin-top: 20px;">
            <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                explore collections
            </a>
        </div>
    </section>

    <!-- 7. Interactive Artisan Showcase Tabs -->
    <section class="home-showcase-tabs" aria-label="Artisan Spotlight">
        <div class="showcase-tabs-nav" role="tablist">
            <button class="showcase-tab-btn active" data-target="#tab-panel-1" role="tab" aria-selected="true">Curated Set 01</button>
            <button class="showcase-tab-btn" data-target="#tab-panel-2" role="tab" aria-selected="false">Curated Set 02</button>
            <button class="showcase-tab-btn" data-target="#tab-panel-3" role="tab" aria-selected="false">Curated Set 03</button>
        </div>

        <!-- Panel 1 -->
        <div id="tab-panel-1" class="showcase-tab-panel active" role="tabpanel">
            <img src="<?= $base_path ?>assets/images/2020/11/j3378po023200-4.jpg" 
                 alt="Artisan Gold Bracelet Showcase" 
                 class="showcase-model-img" loading="lazy">
            <div class="showcase-item-body">
                <img src="<?= $base_path ?>assets/images/2020/11/j3371po033200.png" 
                     alt="Featured Bracelet Detail" 
                     class="showcase-item-img" loading="lazy">
                <a href="<?= $base_path ?>shop/collections/index.php#bracelets" class="editorial-btn">
                    discover pieces
                </a>
            </div>
        </div>

        <!-- Panel 2 -->
        <div id="tab-panel-2" class="showcase-tab-panel" role="tabpanel">
            <img src="<?= $base_path ?>assets/images/2020/11/j3378po023200-3-1.jpg" 
                 alt="Artisan Gold Bracelet Showcase" 
                 class="showcase-model-img" loading="lazy">
            <div class="showcase-item-body">
                <img src="<?= $base_path ?>assets/images/2020/11/j3371po033200-2-1.png" 
                     alt="Featured Bracelet Detail" 
                     class="showcase-item-img" loading="lazy">
                <a href="<?= $base_path ?>shop/collections/index.php#bracelets" class="editorial-btn">
                    discover pieces
                </a>
            </div>
        </div>

        <!-- Panel 3 -->
        <div id="tab-panel-3" class="showcase-tab-panel" role="tabpanel">
            <img src="<?= $base_path ?>assets/images/2020/11/j3378po023200-2-1.jpg" 
                 alt="Artisan Gold Bracelet Showcase" 
                 class="showcase-model-img" loading="lazy">
            <div class="showcase-item-body">
                <img src="<?= $base_path ?>assets/images/2020/11/j3371po033200-3-2.png" 
                     alt="Featured Bracelet Detail" 
                     class="showcase-item-img" loading="lazy">
                <a href="<?= $base_path ?>shop/collections/index.php#bracelets" class="editorial-btn">
                    discover pieces
                </a>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.showcase-tab-btn');
    const tabPanels = document.querySelectorAll('.showcase-tab-panel');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            tabPanels.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            const targetPanel = document.querySelector(this.getAttribute('data-target'));
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
