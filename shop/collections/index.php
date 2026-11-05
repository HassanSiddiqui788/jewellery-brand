<?php
/**
 * Page: Collections – Lorem Ipsum
 */
require_once __DIR__ . '/../../includes/config.php';
$base_path = '../../';
$page_title = 'Collections – Lorem Ipsum';
$current_page = 'collections';

require_once __DIR__ . '/../../includes/header.php';
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Curated Collections</h1>
        <p class="about-page-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor</p>
        <div class="site-category-pills" style="margin-top: 25px;">
            <a href="#necklaces">Necklaces</a>
            <a href="#bracelets">Bracelets</a>
            <a href="#earrings">Earrings</a>
        </div>
    </header>

    <div class="about-container" style="max-width: var(--site-max-width);">
        <!-- 1. Necklaces Collection -->
        <section id="necklaces" class="home-featured-section" style="padding: 30px 0 70px;" aria-label="Necklaces Collection">
            <div class="home-section-header">
                <h2 class="home-section-heading">Necklaces</h2>
                <a href="<?= $base_path ?>shop/categories/necklaces/index.php" class="home-section-link">View Category &rarr;</a>
            </div>
            <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- 1. Exuberant Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/exuberant-golden-necklace/index.php" class="home-product-card" style="position: relative; z-index: 1; pointer-events: auto !important; cursor: pointer !important;">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg" alt="Exuberant Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Exuberant Golden Necklace</h3>
                        <div class="home-product-price">&#36;349.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>

                <!-- 2. Moonrise Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/moonrise-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Moonrise Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Moonrise Golden Necklace</h3>
                        <div class="home-product-price">&#36;299.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>

                <!-- 3. Portlligat Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/portlligat-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Portlligat Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Portlligat Golden Necklace</h3>
                        <div class="home-product-price">&#36;279.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>

                <!-- 4. Nightwave Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/nighwave-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Nightwave Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Nightwave Golden Necklace</h3>
                        <div class="home-product-price">&#36;320.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>

                <!-- 5. Meandres Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/meandres-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Meandres Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Meandres Golden Necklace</h3>
                        <div class="home-product-price">&#36;265.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>

                <!-- 6. Splash Golden Necklace -->
                <a href="<?= $base_path ?>shop/product/splash-golden-necklace/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg" alt="Splash Golden Necklace" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Splash Golden Necklace</h3>
                        <div class="home-product-price">&#36;369.00</div>
                        <div class="home-product-meta">golden &bull; necklaces</div>
                    </div>
                </a>
            </div>
        </section>

        <!-- 2. Bracelets Collection -->
        <section id="bracelets" class="home-featured-section" style="padding: 30px 0 70px;" aria-label="Bracelets Collection">
            <div class="home-section-header">
                <h2 class="home-section-heading">Bracelets</h2>
                <a href="<?= $base_path ?>shop/categories/bracelets/index.php" class="home-section-link">View Category &rarr;</a>
            </div>
            <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- 1. Miro Jewelry Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/miro-jewelry-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Miro Jewelry Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Miro Jewelry Golden Bracelet</h3>
                        <div class="home-product-price">&#36;219.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>

                <!-- 2. Arquitectura Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/arquitectura-golden-bracelet-copy/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Arquitectura Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Arquitectura Golden Bracelet</h3>
                        <div class="home-product-price">&#36;280.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>

                <!-- 3. Portlligat Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/portlligat-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Portlligat Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Portlligat Golden Bracelet</h3>
                        <div class="home-product-price">&#36;195.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>

                <!-- 4. Blush Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/blush-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Blush Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Blush Golden Bracelet</h3>
                        <div class="home-product-price">&#36;240.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>

                <!-- 5. Blossom Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/blossom-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Blossom Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Blossom Golden Bracelet</h3>
                        <div class="home-product-price">&#36;260.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>

                <!-- 6. Olivia Golden Bracelet -->
                <a href="<?= $base_path ?>shop/product/olivia-golden-bracelet/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg" alt="Olivia Golden Bracelet" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Olivia Golden Bracelet</h3>
                        <div class="home-product-price">&#36;225.00</div>
                        <div class="home-product-meta">bracelet &bull; golden</div>
                    </div>
                </a>
            </div>
        </section>

        <!-- 3. Earrings Collection -->
        <section id="earrings" class="home-featured-section" style="padding: 30px 0 70px;" aria-label="Earrings Collection">
            <div class="home-section-header">
                <h2 class="home-section-heading">Earrings</h2>
                <a href="<?= $base_path ?>shop/categories/earrings/index.php" class="home-section-link">View Category &rarr;</a>
            </div>
            <div class="home-products-grid" style="grid-template-columns: repeat(3, 1fr);">
                <!-- 1. Arquitectura Golden Earrings -->
                <a href="<?= $base_path ?>shop/product/arquitectura-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Arquitectura Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Arquitectura Golden Earrings</h3>
                        <div class="home-product-price">&#36;245.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- 2. Curves Golden Earrings -->
                <a href="<?= $base_path ?>shop/product/curves-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Curves Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Curves Golden Earrings</h3>
                        <div class="home-product-price">&#36;195.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- 3. Portlligat Golden Earrings -->
                <a href="<?= $base_path ?>shop/product/portlligat-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Portlligat Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Portlligat Golden Earrings</h3>
                        <div class="home-product-price">&#36;119.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- 4. Angel Hoops -->
                <a href="<?= $base_path ?>shop/product/angel-hoops/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg" alt="Angel Hoops Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Angel Hoops</h3>
                        <div class="home-product-price">&#36;189.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- 5. Esplendida Golden Earrings -->
                <a href="<?= $base_path ?>shop/product/esplendida-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Esplendida Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Esplendida Golden Earrings</h3>
                        <div class="home-product-price">&#36;215.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>

                <!-- 6. Carla Golden Earrings -->
                <a href="<?= $base_path ?>shop/product/carla-golden-earrings/index.php" class="home-product-card">
                    <div class="home-product-thumb">
                        <img src="<?= $base_path ?>assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg" alt="Carla Golden Earrings" loading="lazy">
                    </div>
                    <div class="home-product-info">
                        <h3 class="home-product-title">Carla Golden Earrings</h3>
                        <div class="home-product-price">&#36;175.00</div>
                        <div class="home-product-meta">earrings &bull; golden</div>
                    </div>
                </a>
            </div>
        </section>
    </div>
</main>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>
