<?php
/**
 * Page: Checkout – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Checkout – Lorem Ipsum';
$body_class = 'page page-checkout';
$current_page = 'checkout';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow checkout-page-container">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Checkout</h1>
        <p class="page-hero-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </header>

    <div class="checkout-empty-panel">
        <h2>Lorem Ipsum Dolor</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore.</p>
        <a href="<?= $base_path ?>shop/collections/index.php" class="btn-primary">Return to Shop</a>
    </div>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
