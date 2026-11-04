<?php
/**
 * Page: Privacy Policy – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Privacy Policy – Bijoux';
$body_class = 'page page-privacy theme-bijoux';
$current_page = 'privacy';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Privacy Policy</h1>
        <p class="page-hero-subtitle"><em>Last updated: November 2026</em></p>
    </header>

    <article class="policy-card">
        <div class="policy-content">
            <p>At Bijoux, we value your trust and are committed to protecting your personal information. This Privacy Policy outlines the types of information we collect, how we use and safeguard it, and your rights regarding your data.</p>
            
            <h2>1. Information We Collect</h2>
            <p>When you visit our store or make an order, we may collect the following information:</p>
            <ul>
                <li><strong>Personal Details:</strong> Name, shipping address, billing address, phone number, and email address.</li>
                <li><strong>Transaction Information:</strong> Details of orders placed, payment confirmation status (we do not store raw credit card numbers), and purchase history.</li>
                <li><strong>Browsing Data:</strong> Device details, browser type, and interaction preferences to enhance your shopping experience.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>Your data is used strictly to fulfill your orders, provide customer service, notify you of order status updates, and continuously improve our handcrafted jewelry collections and website performance.</p>

            <h2>3. Security &amp; Data Protection</h2>
            <p>We implement industry-standard technical and organizational security measures to protect your personal information against unauthorized access, alteration, or disclosure.</p>

            <h2>4. Cookies &amp; Preferences</h2>
            <p>Our website utilizes functional cookies to maintain your shopping cart, preserve your navigation preferences, and deliver seamless responsive performance across desktop and mobile devices.</p>

            <h2>5. Contact Us</h2>
            <p>If you have any questions or requests regarding your personal data, please contact our customer care team at <a href="<?= $base_path ?>pages/contact.php">Contact Us</a>.</p>
        </div>
    </article>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
