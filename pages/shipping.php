<?php
/**
 * Page: Delivery & Shipping – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Delivery & Shipping – Bijoux';
$body_class = 'page page-delivery theme-bijoux';
$current_page = 'shipping';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Delivery &amp; Shipping</h1>
        <p class="page-hero-subtitle">Fast, complimentary, and fully insured delivery on all fine jewelry orders.</p>
    </header>

    <article class="policy-card">
        <div class="policy-content">
            <h2>Free Standard Domestic Shipping</h2>
            <p>Our online store offers complimentary 3-5 day shipping for US domestic addresses on all orders. In-stock orders are carefully packed in signature Bijoux luxury packaging and dispatched within 24 hours of confirmation.</p>

            <h2>Order Tracking &amp; Confirmation</h2>
            <p>Once your order has been packaged and handed over to our shipping carriers (USPS or FedEx), you will immediately receive a dispatch confirmation email containing your trackable shipping number.</p>
            <p>Shipments depart Monday through Saturday. Orders placed after 12:00 PM Pacific Standard Time depart on the following business morning.</p>

            <h2>Carriers &amp; Delivery Notifications</h2>
            <ul>
                <li>We partner exclusively with USPS Priority Mail and FedEx Express for insured, signature-required delivery.</li>
                <li>Your tracking number updates automatically as the carrier scans your package through each sorting checkpoint.</li>
                <li>Please allow 12-24 hours after receiving your tracking email for the initial carrier scan to appear online.</li>
            </ul>

            <h2>Expedited &amp; International Delivery</h2>
            <p>Expedited 2-day delivery and overnight services are available at checkout. International shipping rates are calculated at checkout based on weight and country of destination. Customs duties or taxes may apply upon arrival depending on your country's regulations.</p>

            <h2>Questions About Your Delivery?</h2>
            <p>If you have any special delivery instructions, require a specific delivery date for an anniversary or proposal, or have questions about tracking, please reach out via our <a href="<?= $base_path ?>pages/contact.php">Contact Us</a> page.</p>
        </div>
    </article>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>

