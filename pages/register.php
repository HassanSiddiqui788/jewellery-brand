<?php
/**
 * Page: Register / Create Account – Lorem Ipsum
 * Luxury Authentication Frontend
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Create an Account – Lorem Ipsum';
$body_class = 'page page-auth page-register';
$current_page = 'register';

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
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Join our circle of connoisseurs for private previews, bespoke advice & privileges.</p>
            <div class="auth-divider">
                <span>&#9671;</span>
            </div>
        </header>

        <!-- Quick Switcher Tabs -->
        <div class="auth-tabs">
            <a href="<?= $base_path ?>pages/login.php" class="auth-tab">Sign In</a>
            <span class="auth-tab active">Create Account</span>
        </div>

        <!-- Interactive Alert Notification Box -->
        <div id="auth-alert" class="auth-alert"></div>

        <!-- Registration Form -->
        <form id="register-form" class="auth-form" action="" method="post" autocomplete="on">
            <div class="form-row">
                <div class="form-group">
                    <label for="reg-first-name">First Name <span style="color: var(--color-accent);">&bull;</span></label>
                    <div class="input-wrap">
                        <input type="text" id="reg-first-name" name="first_name" required class="form-input" placeholder="e.g. Eleanor" autocomplete="given-name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="reg-last-name">Last Name <span style="color: var(--color-accent);">&bull;</span></label>
                    <div class="input-wrap">
                        <input type="text" id="reg-last-name" name="last_name" required class="form-input" placeholder="e.g. Vance" autocomplete="family-name">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="reg-email">Email Address <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="email" id="reg-email" name="email" required class="form-input" placeholder="e.g. client@loremipsum.com" autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="reg-password">Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reg-password" name="password" minlength="8" required class="form-input" placeholder="At least 8 characters" autocomplete="new-password">
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
                <label for="reg-confirm-password">Confirm Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reg-confirm-password" name="confirm_password" minlength="8" required class="form-input" placeholder="Re-enter your password" autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="auth-remember" style="font-size: 11px; line-height: 1.5; text-transform: none; letter-spacing: 0;">
                    <input type="checkbox" name="terms" required checked>
                    <span>I agree to the <a href="<?= $base_path ?>pages/terms.php" target="_blank" style="color: var(--color-accent); text-decoration: underline;">Terms &amp; Conditions</a> and <a href="<?= $base_path ?>pages/privacy-policy.php" target="_blank" style="color: var(--color-accent); text-decoration: underline;">Privacy Policy</a>.</span>
                </label>
            </div>

            <button type="submit" class="auth-btn-submit">
                <span>Create My Account</span>
                <i class="fas fa-arrow-right" aria-hidden="true" style="font-size: 11px;"></i>
            </button>
        </form>

        <!-- Card Footer Switch -->
        <div class="auth-switch">
            Already have an account? 
            <a href="<?= $base_path ?>pages/login.php">Sign In</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

