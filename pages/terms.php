<?php
/**
 * Page: Terms & Conditions – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Terms & Conditions – Bijoux';
$body_class = 'page page-terms theme-bijoux';
$current_page = 'terms';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Terms &amp; Conditions</h1>
        <p class="page-hero-subtitle"><em>Last updated: November 2026</em></p>
    </header>

    <article class="policy-card">
        <div class="policy-content">
            <p>Welcome to Bijoux. By browsing or purchasing from our website, you agree to comply with and be bound by the following terms and conditions.</p>
            
            <h2>1. Handcrafted Artisan Jewelry</h2>
            <p>Each Bijoux piece is handcrafted with precision using authentic gold, silver, and ethically sourced gemstones. Because of the artisanal handcrafted nature of our jewelry, slight variations in finish, stone cut, or color may occur, making every piece unique.</p>

            <h2>2. Orders &amp; Pricing</h2>
            <p>All prices are listed in USD and are subject to change without notice. We reserve the right to limit quantities or refuse an order if pricing errors occur.</p>

            <h2>3. Shipping &amp; Delivery</h2>
            <p>Orders are packaged in signature Bijoux boxes and shipped via insured trackable carriers. For complete delivery estimates and shipping policies, please review our <a href="<?= $base_path ?>pages/shipping.php">Delivery &amp; Shipping</a> page.</p>

            <h2>4. Returns &amp; Exchanges</h2>
            <p>We want you to love your jewelry. We accept returns of unworn pieces in their original condition within 14 days of delivery. Custom-engraved items are final sale. See our full <a href="<?= $base_path ?>pages/returns.php">Returns &amp; Cancellations</a> policy.</p>

            <h2>5. Intellectual Property</h2>
            <p>All jewelry designs, photographs, branding, and written content on this website are the proprietary property of Bijoux and protected by international intellectual property laws.</p>
        </div>
    </article>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
