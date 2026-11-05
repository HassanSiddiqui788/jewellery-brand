<?php
/**
 * Page: Retail Store – Lorem Ipsum
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Retail Store – Lorem Ipsum';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Visit Our Retail Store</h1>
        <p class="about-page-subtitle">Lorem Ipsum Showroom &bull; By Appointment &amp; Walk-ins Welcome</p>
    </header>

    <div class="site-container" style="max-width: 1050px; padding: 0 24px 80px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center; margin-bottom: 60px;">
            <div>
                <h2 style="font-size: 28px; margin-bottom: 16px;">Lorem Ipsum Store</h2>
                <p style="font-size: 16px; color: var(--color-muted); line-height: 1.7; margin-bottom: 24px;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div style="margin-bottom: 20px;">
                    <strong>Address:</strong><br>
                    720 SW Washington St, Portland, OR 97205
                </div>
                <div>
                    <strong>Hours:</strong><br>
                    Monday &ndash; Saturday: 10:00 AM &ndash; 7:00 PM<br>
                    Sunday: 11:00 AM &ndash; 5:00 PM
                </div>
            </div>
            <div>
                <img src="<?= $base_path ?>assets/images/2020/10/05-1.jpg" alt="Retail Showroom" style="width: 100%; border-radius: var(--radius-sm); box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
