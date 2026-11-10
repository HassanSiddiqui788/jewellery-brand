<?php
/**
 * Page: Account Sign In – Lorem Ipsum
 * Luxury Authentication Frontend
 */
require_once __DIR__ . '/../includes/config.php';
$base_path = '../';
$page_title = 'Sign In – Lorem Ipsum';
$body_class = 'page page-auth page-login';
$current_page = 'login';

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
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to access your saved wishlist, exclusive pieces, and personal orders.</p>
            <div class="auth-divider">
                <span>&#9671;</span>
            </div>
        </header>

        <!-- Quick Switcher Tabs -->
        <div class="auth-tabs">
            <span class="auth-tab active">Sign In</span>
            <a href="<?= $base_path ?>pages/register.php" class="auth-tab">Create Account</a>
        </div>

        <!-- Interactive Alert Notification Box -->
        <div id="auth-alert" class="auth-alert <?= isset($_GET['registered']) ? 'alert-success show' : (isset($_GET['reset']) ? 'alert-success show' : '') ?>">
            <?php if (isset($_GET['registered'])): ?>
                <i class="fas fa-check-circle"></i>
                <span>Your account has been created successfully. Please enter your credentials to continue.</span>
            <?php elseif (isset($_GET['reset'])): ?>
                <i class="fas fa-check-circle"></i>
                <span>Your password has been updated successfully. Please sign in with your new password.</span>
            <?php endif; ?>
        </div>

        <!-- Login Form -->
        <form id="login-form" class="auth-form" action="" method="post" autocomplete="on">
            <div class="form-group">
                <label for="login-email">Email Address <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="email" id="login-email" name="email" required class="form-input" placeholder="e.g. client@loremipsum.com" autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="login-password">Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="login-password" name="password" required class="form-input" placeholder="Enter your password" autocomplete="current-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="auth-options">
                <label class="auth-remember">
                    <input type="checkbox" name="remember" id="remember-me" checked>
                    <span>Keep me signed in</span>
                </label>
                <a href="<?= $base_path ?>pages/forgot-password.php" class="auth-forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="auth-btn-submit">
                <span>Sign In</span>
                <i class="fas fa-arrow-right" aria-hidden="true" style="font-size: 11px;"></i>
            </button>
        </form>

        <!-- Card Footer Switch -->
        <div class="auth-switch">
            Don't have an account yet? 
            <a href="<?= $base_path ?>pages/register.php">Create an account</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

