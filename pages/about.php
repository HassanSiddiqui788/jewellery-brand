<?php
/**
 * Page: About Us – JARWAYA JEWELS
 * Artisanal Heritage & Modern Heirlooms
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'About Us – JARWAYA JEWELS';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';

$featured = get_catalog_products(null, 4);
?>

<main id="main-content" class="site-main">
    <!-- 1. Page Header -->
    <header class="about-page-header">
        <h1 class="about-page-title">About JARWAYA JEWELS</h1>
        <p class="about-page-subtitle">Artisanal Heritage &bull; Sculptural Modernity &bull; Timeless Heirlooms</p>
    </header>

    <div class="about-container">
        <!-- 2. About Us: Brand Philosophy -->
        <section class="about-intro-split" aria-label="Brand Philosophy">
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/02-1.jpg" 
                     alt="JARWAYA JEWELS Artisanal Craftsmanship" 
                     width="876" height="1371" loading="lazy">
            </div>
            <div class="about-intro-text">
                <h2>Our Story</h2>
                <h3>Sculpted for Pure Distinction</h3>
                <p>
                    JARWAYA JEWELS was founded with an enduring devotion to the art of fine jewellery. Inspired by architectural balance and fluid natural silhouettes, our pieces are designed to bridge timeless heritage with contemporary sophistication.
                </p>
                <p>
                    Each creation begins with an obsession for harmonious proportion and graceful contours. We believe jewellery should not merely adorn; it should resonate with individuality and accompany you through life's most meaningful moments.
                </p>
            </div>
        </section>

        <!-- 3. Values & Craftsmanship -->
        <section class="about-values-grid" aria-label="Values and Philosophy">
            <div class="about-value-card">
                <h4>Artisanal Integrity</h4>
                <p>
                    Every curve and facet is brought to life through rigorous craftsmanship. We honor traditional jewellery-making techniques while refining silhouettes for contemporary ease, durability, and luminous beauty.
                </p>
            </div>
            <div class="about-value-card">
                <h4>Enduring Heirlooms</h4>
                <p>
                    We reject fleeting fads in favor of iconic, intentional design. JARWAYA JEWELS creations are crafted as modern heirlooms—pieces destined to be treasured today and passed down with pride tomorrow.
                </p>
            </div>
        </section>

        <!-- 4. Luxury Quote Banner -->
        <section class="about-marquee-banner" aria-label="Brand Motto">
            <h2>JARWAYA JEWELS</h2>
            <p style="font-family: var(--font-serif); font-size: 20px; font-style: italic; color: rgba(255, 255, 255, 0.85); margin: 0;">
                Where sculptural elegance meets timeless modern luxury.
            </p>
        </section>

        <!-- 5. Origins: Story & Craftsmanship -->
        <section class="about-origins-section" aria-label="Our Origins">
            <div class="about-intro-text">
                <h2>The Atelier</h2>
                <h3>Conscious Design &amp; Craft</h3>
                <p>
                    From our signature contoured cuffs to delicately suspended drop pendants, every jewel is shaped to enhance natural radiance. Our artisans hand-inspect and hand-finish each piece to ensure superior comfort and peerless polish.
                </p>
                <div style="margin-top: 25px;">
                    <a href="<?= $base_path ?>shop/collections/index.php" class="editorial-btn">
                        Explore Collections
                    </a>
                </div>
            </div>
            <div class="editorial-image-wrap">
                <img src="<?= $base_path ?>assets/images/2020/10/05-1.jpg" 
                     alt="JARWAYA JEWELS Studio" 
                     width="858" height="1371" loading="lazy">
            </div>
        </section>

        <!-- 6. Curated Collections Preview -->
        <section class="home-featured-section" style="padding-left: 0; padding-right: 0;" aria-label="Curated Works">
            <div class="home-section-header">
                <h2 class="home-section-heading">Featured Works</h2>
                <a href="<?= $base_path ?>shop/index.php" class="home-section-link">Shop Catalog &rarr;</a>
            </div>

            <div class="home-products-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
                <?php if (!empty($featured)): ?>
                    <?php foreach ($featured as $prod): ?>
                        <a href="<?= $base_path ?>shop/product/<?= esc_attr($prod->slug) ?>/index.php" class="home-product-card">
                            <div class="home-product-thumb">
                                <img src="<?= $base_path ?><?= esc_attr($prod->mainImage) ?>" alt="<?= esc_attr($prod->name) ?>" loading="lazy">
                            </div>
                            <div class="home-product-info">
                                <h3 class="home-product-title"><?= e($prod->name) ?></h3>
                                <div class="home-product-price"><?= format_price($prod->effectivePrice()) ?></div>
                                <div class="home-product-meta"><?= e($prod->categoryName ?? 'Jewellery') ?> &bull; handcrafted</div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="<?= $base_path ?>shop/product/splash-golden-necklace/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Splash Golden Necklace" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title">Splash Golden Necklace</h3>
                            <div class="home-product-price">Rs. 28,500</div>
                            <div class="home-product-meta">necklaces &bull; handcrafted</div>
                        </div>
                    </a>
                    <a href="<?= $base_path ?>shop/product/curves-golden-earrings/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?>assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg" alt="Curves Golden Earrings" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title">Curves Golden Earrings</h3>
                            <div class="home-product-price">Rs. 14,500</div>
                            <div class="home-product-meta">earrings &bull; handcrafted</div>
                        </div>
                    </a>
                    <a href="<?= $base_path ?>shop/product/miro-jewelry-golden-bracelet/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Miro Jewelry Golden Bracelet" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title">Miro Jewelry Golden Bracelet</h3>
                            <div class="home-product-price">Rs. 18,500</div>
                            <div class="home-product-meta">bracelets &bull; handcrafted</div>
                        </div>
                    </a>
                    <a href="<?= $base_path ?>shop/product/exuberant-golden-necklace/index.php" class="home-product-card">
                        <div class="home-product-thumb">
                            <img src="<?= $base_path ?>assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg" alt="Exuberant Golden Necklace" loading="lazy">
                        </div>
                        <div class="home-product-info">
                            <h3 class="home-product-title">Exuberant Golden Necklace</h3>
                            <div class="home-product-price">Rs. 24,900</div>
                            <div class="home-product-meta">necklaces &bull; handcrafted</div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
