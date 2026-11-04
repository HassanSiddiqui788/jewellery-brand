<?php
/**
 * Page: Checkout – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Checkout – Bijoux';
$body_class = 'page page-checkout theme-bijoux';
$current_page = 'checkout';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow checkout-page-container">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Checkout</h1>
        <p class="page-hero-subtitle">Secure, insured checkout for your fine jewelry order.</p>
    </header>

    <div class="checkout-empty-panel">
        <h2>Ready to complete your purchase?</h2>
        <p>Review your selected jewelry pieces in your shopping bag before submitting payment details.</p>
        <a href="<?= $base_path ?>shop/collections/index.php" class="btn-primary">Return to Shop</a>
    </div>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
