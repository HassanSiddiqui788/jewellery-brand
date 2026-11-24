<?php
/**
 * Page: Reset Password – JARWAYA JEWELS
 * Luxury Authentication Frontend
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Reset Password – JARWAYA JEWELS';
$body_class = 'page page-auth page-reset-password';
$current_page = 'reset-password';

$page_css = ['auth.css'];
$page_scripts = ['auth.js'];

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="auth-wrapper">
    <div class="auth-card">
        <!-- Brand Header -->
        <header class="auth-header">
            <a href="<?= $base_path ?>index.php" class="auth-logo-link" aria-label="Home">
                <img src="<?= $base_path ?>assets/icons/logo.svg" alt="JARWAYA JEWELS" class="auth-logo-img">
            </a>
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Choose a new, secure password to protect your account and personal collection.</p>
            <div class="auth-divider">
                <span>&#9671;</span>
            </div>
        </header>

        <!-- Interactive Alert Notification Box -->
        <div id="auth-alert" class="auth-alert"></div>

        <!-- Reset Password Form -->
        <form id="reset-form" class="auth-form" action="" method="post" autocomplete="off">
            <div class="form-group">
                <label for="reset-password">New Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reset-password" name="new_password" minlength="8" required class="form-input" placeholder="At least 8 characters" autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                </div>
                <span class="strength-text"></span>
            </div>

            <div class="form-group">
                <label for="reset-confirm-password">Confirm New Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reset-confirm-password" name="confirm_new_password" minlength="8" required class="form-input" placeholder="Re-enter your new password" autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="auth-btn-submit">
                <span>Update Password</span>
                <i class="fas fa-key" aria-hidden="true" style="font-size: 11px;"></i>
            </button>
        </form>

        <!-- Return to Sign In -->
        <div class="auth-switch">
            <a href="<?= $base_path ?>pages/login.php">&larr; Return to Sign In</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

