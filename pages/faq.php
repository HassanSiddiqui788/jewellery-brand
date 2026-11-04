<?php
/**
 * Page: Frequently Asked Questions – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Frequently Asked Questions – Bijoux';
$body_class = 'page page-faq theme-bijoux';
$current_page = 'faq';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <!-- Page Header Banner -->
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Bijoux FAQ</h1>
        <p class="page-hero-subtitle">If you have other burning questions we weren’t able to address here, feel free to email our customer support.</p>
    </header>

    <!-- 1. Products Section -->
    <section class="faq-group">
        <h2 class="faq-category-title">Products</h2>
        
        <details class="faq-item">
            <summary class="faq-question">
                <span>Are the pieces real?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>100%! All our pieces are made of 14-karat gold and never plated. For our flagship collection we use gray diamonds, black diamonds, and opals. If you care for them as we recommend, you will enjoy them forever.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Where and how are they made?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>All of our pieces are handmade by artisan goldsmiths in the Philippines. Coming very soon, we will take you into our studios so you can take a peek at the painstaking process involved in making Bijoux pieces.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Where are the materials from?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We purchase our gold from the Philippines, and our stones and diamonds from Bangkok and India. While we can certify that our stones are conflict-free and ethically sourced, we are currently tracking the source of our gold.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>How is Bijoux different?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Our collection of modular fine jewelry essentials are designed to be creatively customized to keep up with your bold, dynamic life. Our pieces are made of high quality gold and stones, so you can wear them now while you build a jewelry wardrobe you will love forever.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Is there a way I can touch the products?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Yes! You can visit our retail partner stores or schedule a private consultation through our contact page to experience our craftsmanship in person.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Can I bring my old jewelry pieces to you for re-design?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We love collaborating on new designs especially when it involves a piece you love so much. Due to the size of our operation, we are unable to do custom work at all times, but feel free to shoot us an email and we will see what we can do.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>I’m allergic to nickel, will this be a problem with your jewelry?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>All of our 14k solid gold pieces are nickel-free and hypoallergenic, making them safe for sensitive skin.</p>
            </div>
        </details>
    </section>

    <!-- 2. Shipping & Orders Section -->
    <section class="faq-group">
        <h2 class="faq-category-title">Shipping &amp; Delivery</h2>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Will Bijoux deliver to me?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>If you live in any of the 50 states and Puerto Rico, Bijoux will deliver to you. Our pieces might take longer to get to you if you live in Alaska, Hawaii, and Puerto Rico, but they will get there.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What are my shipping options?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>1) Ground (5-8 days): Always complimentary.<br>2) Expedited (2-3 days): Available at checkout for express delivery.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>When will Bijoux ship my order?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>In-stock orders are processed within 1-2 business days. Custom or made-to-order pieces will ship as soon as handcrafting and quality inspection are completed.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>I accidentally put in the wrong address for my order.</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Please contact us immediately through our contact page with your order details so we can update the shipping address before your order dispatches.</p>
            </div>
        </details>
    </section>

    <!-- 3. Returns & Exchanges Section -->
    <section class="faq-group">
        <h2 class="faq-category-title">Returns &amp; Cancellations</h2>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Can I return my jewelry?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We want you to love your pieces! You can return unworn items in their original condition within 14 days of delivery. Custom-made items and personalized pieces are final sale.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>When will I get my money back for my return?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Once we receive and inspect your returned piece, refunds take between 5-10 business days to appear on your original payment statement.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Where should I drop off my return?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>You can drop your return parcel off at any authorized USPS collection box, post office, or FedEx location using the prepaid return label provided.</p>
            </div>
        </details>
    </section>

    <!-- 4. Payment & Checkout Section -->
    <section class="faq-group">
        <h2 class="faq-category-title">Payment &amp; Checkout</h2>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What forms of payment do you accept?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We accept Visa, MasterCard, American Express, Apple Pay, and PayPal.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Can I use multiple promo codes at checkout?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We only accept one promotional code per order at checkout.</p>
            </div>
        </details>
    </section>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
