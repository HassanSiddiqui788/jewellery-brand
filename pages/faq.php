<?php
/**
 * Page: Frequently Asked Questions – JARWAYA JEWELS
 * Fine Jewellery Client Inquiries
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Frequently Asked Questions – JARWAYA JEWELS';
$body_class = 'page page-faq';
$current_page = 'faq';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <!-- Page Header Banner -->
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Frequently Asked Questions</h1>
        <p class="page-hero-subtitle">Find answers to common questions regarding our handcrafted pieces, orders, nationwide delivery in Pakistan, and jewellery care.</p>
    </header>

    <!-- 1. Fine Jewellery & Care -->
    <section class="faq-group">
        <h2 class="faq-category-title">Fine Jewellery &amp; Care</h2>
        
        <details class="faq-item">
            <summary class="faq-question">
                <span>How should I care for my JARWAYA JEWELS piece?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>To preserve the radiant luster of your jewellery, avoid direct exposure to perfumes, hairsprays, chlorinated water, and harsh chemicals. Store each piece separately in the provided JARWAYA protective pouch or jewellery box, and gently buff with a soft microfiber polishing cloth after wearing.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Are JARWAYA JEWELS pieces hypoallergenic?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Yes. Our creations are crafted using nickel-safe and lead-safe metallurgy finished with protective coatings, ensuring effortless and comfortable daily wear even for sensitive skin.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Can I request custom sizing for bracelets or necklaces?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Many of our open-cuff bracelets and extender necklaces offer adjustable fits. For bespoke length adjustments, please reach out to our client concierge before placing your order.</p>
            </div>
        </details>
    </section>

    <!-- 2. Orders & Payment in Pakistan -->
    <section class="faq-group">
        <h2 class="faq-category-title">Orders &amp; Nationwide Delivery</h2>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What payment methods are supported?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We provide convenient <strong>Cash on Delivery (COD)</strong> across all major cities and towns in Pakistan, as well as Direct Bank Transfer for secure, advance settlements.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>How long does delivery take within Pakistan?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Orders in major metropolitan areas (Karachi, Lahore, Islamabad, Rawalpindi) typically arrive within 2 to 3 business days. Delivery to other cities and regional districts takes 3 to 5 business days via tracked, insured couriers.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What packaging will my jewellery arrive in?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Each order is nestled inside our signature JARWAYA JEWELS presentation box, accompanied by a protective velvet travel pouch and authenticity card, ready for gifting or safe keeping.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What is your return or exchange policy?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We offer a 48-hour inspection period from delivery. If your piece arrives with any manufacturing flaw or transit damage, contact our concierge immediately for an exchange or resolution.</p>
            </div>
        </details>
    </section>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
