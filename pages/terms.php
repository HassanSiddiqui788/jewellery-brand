<?php
/**
 * Page: Terms & Conditions – Bijoux
 * Bijoux Jewelry Store
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Terms & Conditions – Bijoux';
$body_class = 'page-template-default page terms-and-conditions wp-custom-logo wp-theme-bijoux theme-bijoux full header-layout-logo-menu has-page-header no-middle-header responsive-layout vamtam-is-elementor elementor-default elementor-kit-4';
$current_page = 'faq';

require_once __DIR__ . '/../includes/header.php';
?>


<div class="bijoux-legal-content">
    <h1>Terms & Conditions</h1>
    <p><em>Last updated: November 2026</em></p>
    <p>Welcome to Bijoux. By browsing or purchasing from our website, you agree to comply with and be bound by the following terms and conditions.</p>
    
    <h2>1. Handcrafted Artisan Jewelry</h2>
    <p>Each Bijoux piece is handcrafted with precision using authentic gold, silver, and ethically sourced gemstones. Because of the artisanal handcrafted nature of our jewelry, slight variations in finish, stone cut, or color may occur, making every piece unique.</p>

    <h2>2. Orders & Pricing</h2>
    <p>All prices are listed in USD and are subject to change without notice. We reserve the right to limit quantities or refuse an order if pricing errors occur.</p>

    <h2>3. Shipping & Delivery</h2>
    <p>Orders are packaged in signature Bijoux boxes and shipped via insured trackable carriers. For complete delivery estimates and shipping policies, please review our <a href="<?= $base_path ?>pages/shipping.php">Delivery & Shipping</a> page.</p>

    <h2>4. Returns & Exchanges</h2>
    <p>We want you to love your jewelry. We accept returns of unworn pieces in their original condition within 14 days of delivery. Custom-engraved items are final sale. See our full <a href="<?= $base_path ?>pages/returns.php">Returns & Cancellations</a> policy.</p>

    <h2>5. Intellectual Property</h2>
    <p>All jewelry designs, photographs, branding, and written content on this website are the proprietary property of Bijoux and protected by international intellectual property laws.</p>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
