<?php
/**
 * Page: Boutique Showroom – JARWAYA JEWELS
 * Flagship Boutique & Private Viewings
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Boutique Showroom – JARWAYA JEWELS';
$current_page = 'about';

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="site-main">
    <header class="about-page-header">
        <h1 class="about-page-title">Flagship Boutique &amp; Atelier</h1>
        <p class="about-page-subtitle">JARWAYA JEWELS Showroom &bull; By Private Appointment &amp; Walk-ins Welcome</p>
    </header>

    <div class="site-container" style="max-width: 1050px; padding: 0 24px 80px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: center; margin-bottom: 60px;">
            <div>
                <h2 style="font-size: 28px; margin-bottom: 16px;">The Lahore Atelier</h2>
                <p style="font-size: 16px; color: var(--color-muted); line-height: 1.7; margin-bottom: 24px;">
                    We welcome you to experience the tactile beauty and luminous presence of JARWAYA JEWELS in person. Schedule a private consultation with our jewellery advisors or visit our boutique to explore our full curated collection.
                </p>
                <div style="margin-bottom: 20px; font-size: 15px; line-height: 1.6;">
                    <strong>Boutique Address:</strong><br>
                    M.M. Alam Road, Gulberg III, Lahore, Pakistan
                </div>
                <div style="margin-bottom: 20px; font-size: 15px; line-height: 1.6;">
                    <strong>Concierge &amp; Appointments:</strong><br>
                    Phone: <a href="tel:+923001234567" style="color: var(--color-navy); text-decoration: underline;">+92 (300) 123-4567</a><br>
                    Email: <a href="mailto:concierge@jarwayajewels.com" style="color: var(--color-navy); text-decoration: underline;">concierge@jarwayajewels.com</a>
                </div>
                <div style="font-size: 15px; line-height: 1.6;">
                    <strong>Visiting Hours:</strong><br>
                    Monday &ndash; Saturday: 11:00 AM &ndash; 8:00 PM (PKT)<br>
                    Sunday: By Prior Appointment Only
                </div>
            </div>
            <div>
                <img src="<?= $base_path ?>assets/images/2020/10/05-1.jpg" alt="JARWAYA JEWELS Retail Showroom" style="width: 100%; border-radius: var(--radius-sm); box-shadow: 0 10px 30px rgba(0,0,0,0.06);">
            </div>
        </div>
    </div>
</main>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
