<?php
/**
 * Page: About Us – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'About Us – Lorem Ipsum';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-main">
    <!-- 1. Page Header -->
    <header class="about-page-header">
        <h1 class="about-page-title">About Us</h1>
        <p class="about-page-subtitle">Lorem Ipsum &bull; Consectetur Adipiscing &bull; Sed Do Eiusmod</p>
    </header>

    <div class="about-container">
        <!-- 2. About Us: Modular Fine Jewelry -->
        <section class="about-intro-split" aria-label="About Us">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/02-1.jpg" 
                     alt="Lorem Ipsum Craftsmanship" 
                     width="876" height="1371" loading="lazy">
            </div>
            <div class="about-intro-text">
                <h2>About Us</h2>
                <h3>Lorem Ipsum Dolor</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
            </div>
        </section>

        <!-- 3. Precious Metals: Values & Philosophy -->
        <section class="about-values-grid" aria-label="Values and Philosophy">
            <div class="about-value-card">
                <h4>Lorem Ipsum</h4>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.
                </p>
            </div>
            <div class="about-value-card">
                <h4>Dolor Sit Amet</h4>
                <p>
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </section>

        <!-- 4. Luxury Quote Banner -->
        <section class="about-marquee-banner" aria-label="Brand Motto">
            <h2>Lorem Ipsum</h2>
            <p style="font-family: var(--font-serif); font-size: 20px; font-style: italic; color: rgba(255, 255, 255, 0.85); margin: 0;">
                Consectetur adipiscing elit sed do eiusmod tempor.
            </p>
        </section>

        <!-- 5. Origins: Story & Craftsmanship -->
        <section class="about-origins-section" aria-label="Our Origins">
            <div class="about-intro-text">
                <h2>Lorem Ipsum</h2>
                <h3>Consectetur Adipiscing</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <div style="margin-top: 25px;">
                    <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                        Explore Collections
                    </a>
                </div>
            </div>
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/05-1.jpg" 
                     alt="Lorem Ipsum Origins" 
                     width="858" height="1371" loading="lazy">
            </div>
        </section>

        <!-- 6. Curated Collections Preview (Necklaces, Bracelets, Earrings) -->
        <section class="home-featured-section" style="padding-left: 0; padding-right: 0;" aria-label="Curated Works">
            <div class="home-section-header">
                <h2 class="home-section-heading">Featured Works</h2>
                <a href="<?= $base_path ?>shop/index.php" class="home-section-link">Shop Catalog &rarr;</a>
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

                <!-- Product 3: Miro Jewelry Golden Bracelet -->
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
