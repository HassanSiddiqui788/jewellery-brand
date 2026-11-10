<?php
/**
 * Page: Forgot Password – Lorem Ipsum
 * Luxury Authentication Frontend
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Forgot Password – Lorem Ipsum';
$body_class = 'page page-auth page-forgot-password';
$current_page = 'forgot-password';

$page_css = ['auth.css'];
$page_scripts = ['auth.js'];

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="auth-wrapper">
    <div class="auth-card">
        <!-- Brand Header -->
        <header class="auth-header">
            <a href="<?= $base_path ?>index.php" class="auth-logo-link" aria-label="Home">
                <img src="<?= $base_path ?>assets/icons/logo.svg" alt="Lorem Ipsum" class="auth-logo-img">
            </a>
            <h1 class="auth-title">Forgot Password</h1>
            <p class="auth-subtitle">Provide your registered email address and we will dispatch a secure link to reset your credentials.</p>
            <div class="auth-divider">
                <span>&#9671;</span>
            </div>
        </header>

        <!-- Interactive Alert Notification Box -->
        <div id="auth-alert" class="auth-alert"></div>

        <!-- Forgot Password Form -->
        <form id="forgot-form" class="auth-form" action="" method="post" autocomplete="on">
            <div class="form-group">
                <label for="forgot-email">Account Email Address <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="email" id="forgot-email" name="email" required class="form-input" placeholder="e.g. client@loremipsum.com" autocomplete="email">
                </div>
            </div>

            <button type="submit" class="auth-btn-submit">
                <span>Send Reset Link</span>
                <i class="fas fa-paper-plane" aria-hidden="true" style="font-size: 11px;"></i>
            </button>
        </form>

        <!-- Return to Sign In -->
        <div class="auth-switch">
            Remember your password? 
            <a href="<?= $base_path ?>pages/login.php">&larr; Return to Sign In</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

