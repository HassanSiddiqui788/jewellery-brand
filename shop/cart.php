<?php
/**
 * Page: Shopping Cart – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Shopping Cart – Lorem Ipsum';
$body_class = 'page page-cart';
$current_page = 'cart';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow cart-page-container">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Your Shopping Bag</h1>
        <p class="page-hero-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </header>

    <div id="full-cart-content-wrapper">
        <!-- Live cart table or empty state rendered via JavaScript -->
        <div class="cart-empty-panel">
            <h2>Your bag is currently empty</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor.</p>
            <a href="<?= $base_path ?>shop/collections/index.php" class="btn-primary">Explore Collections</a>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
