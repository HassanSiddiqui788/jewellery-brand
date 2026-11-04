<?php
/**
 * Page: Our Story – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Our Story – Bijoux';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-main">
    <!-- 1. Page Header -->
    <header class="about-page-header">
        <h1 class="about-page-title">Our Story</h1>
        <p class="about-page-subtitle">Artisan Handcrafted &bull; Ethically Sourced &bull; Timeless Elegance</p>
    </header>

    <div class="about-container">
        <!-- 2. About Us: Modular Fine Jewelry -->
        <section class="about-intro-split" aria-label="About Us">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/02-1.jpg" 
                     alt="Artisan Jewelry Craftsmanship" 
                     width="876" height="1371" loading="lazy">
            </div>
            <div class="about-intro-text">
                <h2>About Us</h2>
                <h3>Modular Fine Jewelry</h3>
                <p>
                    With Bijoux, we’ve built a clever, customizable jewelry line that morphs with you. 
                    A necklace becomes a pair of anklets; an earring turns into a ring. Crafted from the finest materials 
                    and precious stones, Bijoux’s contemporary fine jewelry can be modified to match your mood, 
                    no matter where you are.
                </p>
            </div>
        </section>

        <!-- 3. Precious Metals: Values & Philosophy -->
        <section class="about-values-grid" aria-label="Values and Philosophy">
            <div class="about-value-card">
                <h4>Our Values</h4>
                <p>
                    The world is our home and we are called to leave it better than we found it. 
                    Everything we do, from creating sustainable products to building communities, is based on that principle. 
                    When you buy Bijoux jewelry, you’re supporting our artists and helping them make their lives, 
                    and the lives of their families, better.
                </p>
            </div>
            <div class="about-value-card">
                <h4>Our Philosophy</h4>
                <p>
                    Built on the idea that life is yours for the making, Bijoux is a modular fine jewelry brand that, 
                    in its modularity, empowers you to live exactly as you are in a world of limitless possibilities.
                </p>
            </div>
        </section>

        <!-- 4. Luxury Quote Banner -->
        <section class="about-marquee-banner" aria-label="Brand Motto">
            <h2>Bijoux</h2>
            <p style="font-family: var(--font-serif); font-size: 20px; font-style: italic; color: rgba(255, 255, 255, 0.85); margin: 0;">
                Anything less is simply unacceptable.
            </p>
        </section>

        <!-- 5. Origins: Story & Craftsmanship -->
        <section class="about-origins-section" aria-label="Our Origins">
            <div class="about-intro-text">
                <h2>Our Origins</h2>
                <h3>Accessible Luxury Heirlooms</h3>
                <p>
                    We make it our business to bring you heirloom-quality jewelry without the traditional retail markup. 
                    Every gem is ethically sourced, and every setting is hand-cast by master artisans who have perfected 
                    their craft across generations.
                </p>
                <div style="margin-top: 25px;">
                    <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                        Explore Creations
                    </a>
                </div>
            </div>
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/05-1.jpg" 
                     alt="Our Origins Jewelry Art" 
                     width="858" height="1371" loading="lazy">
            </div>
        </section>

        <!-- 6. Curated Collections Preview -->
        <section class="home-featured-section" style="padding-left: 0; padding-right: 0;" aria-label="Curated Works">
            <div class="home-section-header">
                <h2 class="home-section-heading">Featured Heirlooms</h2>
                <a href="<?= $base_path ?>shop/index.php" class="home-section-link">Shop All Catalog &rarr;</a>
            </div>

            <div class="home-products-grid">
                <!-- Product 1: Angel Hoops -->
                <a href="<?= $base_path ?>shop/product/angel-hoops/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg" 
                             alt="Angel Hoops Golden Earrings" 
                             width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Angel Hoops</h3>
                        <div class="home-product-price">&#36;189.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- Product 2: Arquitectura Earrings -->
                <a href="<?= $base_path ?>shop/product/arquitectura-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" 
                             alt="Arquitectura Golden Earrings" 
                             width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Arquitectura Golden Earrings</h3>
                        <div class="home-product-price">&#36;245.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- Product 3: Bliss Golden Ring -->
                <a href="<?= $base_path ?>shop/product/bliss-golden-ring/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/09/j3368an0132.pw-1280-420x381.jpg" 
                             alt="Bliss Golden Ring" 
                             width="420" height="381" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Bliss Golden Ring</h3>
                        <div class="home-product-price">&#36;229.00</div>
                        <div class="home-product-meta">golden &bull; ring</div>
                    </div>
                </a>

                <!-- Product 4: Exuberant Necklace -->
                <a href="<?= $base_path ?>shop/product/exuberant-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" 
                             alt="Exuberant Golden Necklace" 
                             width="420" height="583" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Exuberant Golden Necklace</h3>
                        <div class="home-product-price">&#36;349.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>
            </div>
        </section>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
