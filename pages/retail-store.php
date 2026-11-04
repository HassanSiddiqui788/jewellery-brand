<?php
/**
 * Page: Retail Store – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Retail Store – Bijoux';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Visit Our Retail Store</h1>
        <p class="about-page-subtitle">Portland Flagship Showroom &bull; By Appointment &amp; Walk-ins Welcome</p>
    </header>

    <div class="about-container">
        <!-- Store Address Banner -->
        <div style="background: #ffffff; border: 1px solid var(--color-border); border-radius: 4px; padding: 25px 20px; text-align: center; margin-bottom: 50px;">
            <p style="font-family: var(--font-serif); font-size: 22px; color: var(--color-primary); margin: 0;">
                <i class="fas fa-map-marker-alt" style="color: var(--color-accent); margin-right: 8px;"></i>
                450 NW Couch Street, Portland, Oregon 97209
            </p>
        </div>

        <!-- Store Details Grid -->
        <div class="retail-store-grid">
            <!-- Left: Store Info Card -->
            <div class="store-card">
                <h2 style="font-family: var(--font-serif); font-size: 32px; margin: 0 0 16px 0; color: var(--color-primary);">
                    The Flagship Showroom
                </h2>
                <p style="font-size: 15px; line-height: 1.7; color: var(--color-text); margin-bottom: 30px;">
                    Our showroom is our place of power! And we are always glad to see you here. We are waiting for you, and not only to help you with choosing perfect new jewelry, but just for a cup of coffee, a glass of prosecco and warm conversations.
                </p>

                <div class="store-detail-row">
                    <span class="store-detail-label">Store Hours</span>
                    <p class="store-detail-value">
                        Monday &ndash; Friday: 10:00 AM &ndash; 7:00 PM<br>
                        Saturday: 11:00 AM &ndash; 6:00 PM<br>
                        Sunday: Closed for private appointments
                    </p>
                </div>

                <div class="store-detail-row">
                    <span class="store-detail-label">Phone Inquiries</span>
                    <p class="store-detail-value">
                        <a href="tel:5039542593" style="color: var(--color-primary); text-decoration: none; font-weight: 500;">
                            (503) 954-2593
                        </a>
                    </p>
                </div>

                <div class="store-detail-row">
                    <span class="store-detail-label">Private Styling</span>
                    <p class="store-detail-value">
                        Schedule an exclusive 1-on-1 consultation with our master gemologists.
                    </p>
                </div>

                <div style="margin-top: 35px;">
                    <a href="<?= $base_path ?>pages/contact.php" class="editorial-btn">
                        Book An Appointment
                    </a>
                </div>
            </div>

            <!-- Right: Boutique Gallery -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="editorial-image-wrap">
                    <img src="<?= $base_path ?>assets/images/2020/09/istockphoto-1173372917-2048x2048-1.jpg" 
                         alt="Bijoux Retail Boutique Showroom" 
                         width="572" height="914" loading="lazy">
                </div>
                <div class="editorial-image-wrap">
                    <img src="<?= $base_path ?>assets/images/2020/09/iStock-1153651611.jpg" 
                         alt="Fine Jewelry Display" 
                         width="572" height="914" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
