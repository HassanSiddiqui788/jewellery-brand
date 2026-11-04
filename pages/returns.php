<?php
/**
 * Page: Return & Cancellations – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Returns & Cancellations – Bijoux';
$body_class = 'page page-returns theme-bijoux';
$current_page = 'returns';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Returns &amp; Cancellations</h1>
        <p class="page-hero-subtitle">Our commitment to your complete satisfaction with every fine jewelry piece.</p>
    </header>

    <section class="faq-group">
        <details class="faq-item" open>
            <summary class="faq-question">
                <span>Are the goods insured during transit?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Absolutely, yes. Bijoux insures each purchase during the time it is in transit until it is safely delivered to you. Because we want to make sure you receive your products, we require a signature upon delivery for high-value fine jewelry items.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Why am I being charged taxes and duties?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Domestic US sales taxes are applied according to state regulations at checkout. For international destinations, any additional customs duties, foreign taxes, or import fees imposed by local authorities are the responsibility of the customer.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What is the Return &amp; Refund Policy?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>We are confident that you will love and cherish our craftsmanship. You have 14 days from delivery to try on your piece. If it doesn’t work out, simply reach out to us through our contact page to receive a return authorization and prepaid shipping label.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>What is your Exchange Policy?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>If you need an alternate ring size or wish to exchange for another design, we will happily process it as a return and credit your account for the replacement order. Please contact our concierge team to coordinate your exchange.</p>
            </div>
        </details>
    </section>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
