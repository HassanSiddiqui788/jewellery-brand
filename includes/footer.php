<?php
/**
 * Global Universal Footer Component
 * Single Source of Truth for Bijoux Jewelry Store
 */
$base_path = $base_path ?? './';
?>
        </div><!-- /#main-content -->
    </div><!-- /#page -->

    <!-- =====================================================================
         Universal Luxury Footer Component
         ===================================================================== -->
    <footer id="main-footer" class="main-footer site-footer">
        <div class="site-container">
            <!-- Brand Logo -->
            <div class="footer-logo-wrap">
                <a href="<?= $base_path ?>index.php" aria-label="Bijoux Home">
                    <img width="156" height="30" src="<?= $base_path ?>assets/icons/logo.svg" alt="Bijoux Jewelry" class="footer-logo-img">
                </a>
            </div>

            <!-- 3 Balanced Navigation Columns -->
            <div class="footer-columns-container">
                <!-- Column 1: About -->
                <div class="footer-col">
                    <h5 class="footer-col-title">About</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= $base_path ?>pages/about.php">Our Story</a></li>
                        <li><a href="<?= $base_path ?>blog/index.php">Journal</a></li>
                        <li><a href="<?= $base_path ?>pages/our-materials.php">Our Materials</a></li>
                        <li><a href="<?= $base_path ?>pages/contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Column 2: Store -->
                <div class="footer-col">
                    <h5 class="footer-col-title">Store</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= $base_path ?>shop/collections/index.php">Collections</a></li>
                        <li><a href="<?= $base_path ?>pages/customer-reviews.php">Customer Reviews</a></li>
                        <li><a href="<?= $base_path ?>pages/retail-store.php">Retail Store</a></li>
                        <li><a href="<?= $base_path ?>pages/gift-cards.php">Gift Cards</a></li>
                    </ul>
                </div>

                <!-- Column 3: Care -->
                <div class="footer-col">
                    <h5 class="footer-col-title">Care</h5>
                    <ul class="footer-nav-list">
                        <li><a href="<?= $base_path ?>pages/shipping.php">Delivery</a></li>
                        <li><a href="<?= $base_path ?>pages/returns.php">Return &amp; Cancellations</a></li>
                        <li><a href="<?= $base_path ?>pages/faq.php">FAQ</a></li>
                        <li><a href="<?= $base_path ?>pages/privacy-policy.php">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Luxury Decorative Typography Banner -->
        <div class="footer-marquee-top">
            <span class="footer-marquee-text">Anything less is</span>
        </div>

        <!-- Centered Social Icons -->
        <div class="footer-social-wrap">
            <div class="footer-social-icons">
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram" class="footer-social-link">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook" class="footer-social-link">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://etsy.com" target="_blank" rel="noopener" aria-label="Etsy" class="footer-social-link">
                    <i class="fab fa-etsy"></i>
                </a>
            </div>
        </div>

        <div class="footer-marquee-bottom">
            <span class="footer-marquee-text">simply unacceptable.</span>
        </div>

        <!-- Copyright Bottom Bar -->
        <div class="footer-copyright-bar">
            <div class="site-container">
                <p>Copyright &copy; <?= date('Y') ?> <a href="<?= $base_path ?>index.php">Bijoux</a>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <div id="scroll-to-top" class="vamtam-scroll-to-top icon" aria-label="Scroll to top" role="button" tabindex="0">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
            <path d="M15.098 8.344L.678 21.164C.081 21.694 0 22.645.5 23.279c.499.638 1.385.725 1.983.193l13.518-12.018 13.516 12.02c.6.53 1.486.445 1.985-.193s.419-1.585-.178-2.115L16.906 8.345c-.263-.234-.584-.351-.905-.351s-.641.118-.902.35z" />
        </svg>
    </div>

    <!-- Side Cart Drawer Component -->
    <?php include __DIR__ . '/components/side-cart.php'; ?>

    <!-- Mega Menu Popups (Collections 1122 & Side Menu 998) -->
    <?php include __DIR__ . '/components/popups.php'; ?>

    <!-- Essential Scripts -->
    <?php include __DIR__ . '/scripts.php'; ?>
</body>
</html>
