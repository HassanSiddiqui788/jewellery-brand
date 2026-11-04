<?php
/**
 * Page: Contact Us – Bijoux
 * Clean, semantic custom architecture
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Contact Us – Bijoux';
$body_class = 'page page-contact theme-bijoux';
$current_page = 'contact';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container">
    <div class="contact-grid">
        <!-- 1. Contact Information -->
        <div class="contact-info-col">
            <h1>Contacts</h1>
            <p>We are delighted to assist you with order inquiries, sizing questions, bespoke requests, or styling advice.</p>
            <p>
                <strong>Phone:</strong><br>
                <a href="tel:5039542593" class="contact-info-phone">(503) 954-2593</a>
            </p>
            <p>
                <strong>Concierge Hours:</strong><br>
                Monday &ndash; Friday: 9:00 AM &ndash; 6:00 PM PST<br>
                Saturday: 10:00 AM &ndash; 4:00 PM PST
            </p>
        </div>

        <!-- 2. Editorial Imagery -->
        <div class="contact-image-col">
            <img src="<?= $base_path ?>assets/images/2020/09/iStock-1153651470-Rings.jpg" alt="Artisan Fine Jewelry Rings" width="848" height="1250">
        </div>

        <!-- 3. Clean Contact Form -->
        <div class="contact-form-col">
            <h2 style="font-size: 24px; margin-bottom: 24px;">Send a Message</h2>
            <form action="" method="post" class="clean-contact-form">
                <div class="form-group">
                    <label for="contact-name">Your Name</label>
                    <input type="text" id="contact-name" name="name" required class="form-input" placeholder="e.g. Eleanor Vance">
                </div>

                <div class="form-group">
                    <label for="contact-email">Your Email</label>
                    <input type="email" id="contact-email" name="email" required class="form-input" placeholder="e.g. eleanor@example.com">
                </div>

                <div class="form-group">
                    <label for="contact-message">Your Message</label>
                    <textarea id="contact-message" name="message" rows="5" required class="form-textarea" placeholder="How can we assist you today?"></textarea>
                </div>

                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>
    </div>
</main>

<?php
include __DIR__ . '/../includes/footer.php';
?>
