<?php
/**
 * Admin Page: Logout Screen (Design Preview)
 */
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signed Out – <?= e_admin(ADMIN_SITE_NAME) ?> Admin</title>

    <link rel="icon" href="../assets/images/favicons/cropped-favicon-32x32.png" sizes="32x32" />
    <link rel="stylesheet" href="../assets/css/montserrat.css" media="all" />
    <link rel="stylesheet" href="../assets/css/sortsmillgoudy.css" media="all" />
    <link rel="stylesheet" href="../assets/css/jomolhari.css" media="all" />
    <link rel="stylesheet" href="../assets/css/fontawesome.min.css" media="all" />
    <link rel="stylesheet" href="../assets/css/all.min.css" media="all" />
    <link rel="stylesheet" href="assets/css/admin.css" media="all" />
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; background-color: var(--color-cream);">

    <div class="admin-card" style="max-width: 480px; width: 100%; padding: 48px 36px; text-align: center; border-top: 3px solid var(--color-accent);">
        <div style="margin-bottom: 18px;">
            <img src="../assets/icons/logo.svg" alt="<?= e_admin(ADMIN_SITE_NAME) ?>" style="height: 26px; margin: 0 auto;" />
        </div>

        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 22px; color: var(--color-accent); font-size: 11px;">
            <span style="height: 1px; width: 40px; background: rgba(203,146,116,0.4);"></span>
            <span>&#9672;</span>
            <span style="height: 1px; width: 40px; background: rgba(203,146,116,0.4);"></span>
        </div>

        <h1 style="font-size: 28px; margin-bottom: 10px;">Signed Out Safely</h1>
        <p style="color: var(--color-muted); font-size: 13.5px; margin: 0 0 28px;">
            You have exited the Atelier Admin Studio. Thank you for managing your collection.
        </p>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <a href="index.php" class="btn btn-primary" style="width: 100%; padding: 13px 20px;">
                <i class="fas fa-th-large" aria-hidden="true"></i> Return to Admin Dashboard
            </a>
            <a href="../index.php" class="btn btn-outline" style="width: 100%; padding: 12px 20px;">
                <i class="fas fa-store" aria-hidden="true"></i> Visit Customer Storefront
            </a>
        </div>
    </div>

</body>
</html>

