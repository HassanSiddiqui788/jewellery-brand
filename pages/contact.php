<?php
/**
 * Page: Contact Us – JARWAYA JEWELS
 * Concierge & Client Advisory Services
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Contact Us – JARWAYA JEWELS';
$body_class = 'page page-contact';
$current_page = 'contact';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container">
    <div class="contact-grid">
        <!-- 1. Contact Information -->
        <div class="contact-info-col">
            <h1>Client Concierge</h1>
            <p>Our dedicated client advisors are here to assist you with order inquiries, styling consultations, bespoke requests, and delivery updates.</p>
            
            <p>
                <strong>Boutique Advisory &amp; WhatsApp:</strong><br>
                <a href="tel:+923001234567" class="contact-info-phone">+92 (300) 123-4567</a>
            </p>
            
            <p>
                <strong>Email:</strong><br>
                <a href="mailto:concierge@jarwayajewels.com" style="color: var(--color-navy); text-decoration: underline;">concierge@jarwayajewels.com</a>
            </p>

            <p>
                <strong>Concierge Hours:</strong><br>
                Monday &ndash; Friday: 10:00 AM &ndash; 7:00 PM (PKT)<br>
                Saturday: 11:00 AM &ndash; 5:00 PM (PKT)<br>
                Sunday: Closed
            </p>
        </div>

        <!-- 2. Editorial Imagery -->
        <div class="contact-image-col">
            <img src="<?= $base_path ?>assets/images/2020/09/iStock-1153651470-Rings.jpg" alt="JARWAYA JEWELS Concierge" width="848" height="1250">
        </div>

        <!-- 3. Clean Contact Form -->
        <div class="contact-form-col">
            <h2 style="font-size: 24px; margin-bottom: 24px;">Send a Message</h2>
            <form action="" method="post" class="clean-contact-form">
                <div class="form-group">
                    <label for="contact-name">Your Full Name</label>
                    <input type="text" id="contact-name" name="name" required class="form-input" placeholder="e.g. Ayesha Khan">
                </div>

                <div class="form-group">
                    <label for="contact-email">Email Address</label>
                    <input type="email" id="contact-email" name="email" required class="form-input" placeholder="e.g. ayesha@example.com">
                </div>

                <div class="form-group">
                    <label for="contact-subject">Subject</label>
                    <input type="text" id="contact-subject" name="subject" class="form-input" placeholder="e.g. Order Inquiry / Styling Advice">
                </div>

                <div class="form-group">
                    <label for="contact-message">Your Message</label>
                    <textarea id="contact-message" name="message" rows="5" required class="form-input form-textarea" placeholder="How may our concierge assist you today?"></textarea>
                </div>

                <button type="submit" class="contact-submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
