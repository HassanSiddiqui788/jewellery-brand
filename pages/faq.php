<?php
/**
 * Page: Frequently Asked Questions – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Frequently Asked Questions – Lorem Ipsum';
$body_class = 'page page-faq';
$current_page = 'faq';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container-narrow">
    <!-- Page Header Banner -->
    <header class="page-hero-banner">
        <h1 class="page-hero-title">Frequently Asked Questions</h1>
        <p class="page-hero-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore.</p>
    </header>

    <!-- 1. Products Section -->
    <section class="faq-group">
        <h2 class="faq-category-title">Lorem Ipsum</h2>
        
        <details class="faq-item">
            <summary class="faq-question">
                <span>Lorem ipsum dolor sit amet?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Consectetur adipiscing elit sed do eiusmod?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Ut enim ad minim veniam quis nostrud?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Duis aute irure dolor in reprehenderit?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>
            </div>
        </details>
    </section>

    <!-- 2. Orders & Shipping -->
    <section class="faq-group">
        <h2 class="faq-category-title">Dolor Sit Amet</h2>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Excepteur sint occaecat cupidatat non proident?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat.</p>
            </div>
        </details>

        <details class="faq-item">
            <summary class="faq-question">
                <span>Tempor incididunt ut labore et dolore?</span>
                <i class="fas fa-chevron-down faq-chevron" aria-hidden="true"></i>
            </summary>
            <div class="faq-answer">
                <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur.</p>
            </div>
        </details>
    </section>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
