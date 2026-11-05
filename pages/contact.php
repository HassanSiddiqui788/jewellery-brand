<?php
/**
 * Page: Contact Us – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Contact Us – Lorem Ipsum';
$body_class = 'page page-contact';
$current_page = 'contact';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-container">
    <div class="contact-grid">
        <!-- 1. Contact Information -->
        <div class="contact-info-col">
            <h1>Contacts</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <p>
                <strong>Phone:</strong><br>
                <a href="tel:5039542593" class="contact-info-phone">(503) 954-2593</a>
            </p>
            <p>
                <strong>Hours:</strong><br>
                Monday &ndash; Friday: 9:00 AM &ndash; 6:00 PM PST<br>
                Saturday: 10:00 AM &ndash; 4:00 PM PST
            </p>
        </div>

        <!-- 2. Editorial Imagery -->
        <div class="contact-image-col">
            <img src="<?= $base_path ?>assets/images/2020/09/iStock-1153651470-Rings.jpg" alt="Lorem Ipsum Jewelry" width="848" height="1250">
        </div>

        <!-- 3. Clean Contact Form -->
        <div class="contact-form-col">
            <h2 style="font-size: 24px; margin-bottom: 24px;">Send a Message</h2>
            <form action="" method="post" class="clean-contact-form">
                <div class="form-group">
                    <label for="contact-name">Your Name</label>
                    <input type="text" id="contact-name" name="name" required class="form-input" placeholder="e.g. Lorem Ipsum">
                </div>

                <div class="form-group">
                    <label for="contact-email">Your Email</label>
                    <input type="email" id="contact-email" name="email" required class="form-input" placeholder="e.g. lorem@example.com">
                </div>

                <div class="form-group">
                    <label for="contact-subject">Subject</label>
                    <input type="text" id="contact-subject" name="subject" class="form-input" placeholder="e.g. Order Inquiry">
                </div>

                <div class="form-group">
                    <label for="contact-message">Your Message</label>
                    <textarea id="contact-message" name="message" rows="5" required class="form-input form-textarea" placeholder="Write your message here..."></textarea>
                </div>

                <button type="submit" class="contact-submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
