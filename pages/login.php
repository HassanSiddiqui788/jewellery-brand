<?php
/**
 * Page: Account Sign In – Lorem Ipsum
 * Luxury Authentication Frontend & Dynamic Login Processing
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../app/Services/AuthService.php';

$base_path = '../';
$page_title = 'Sign In – Lorem Ipsum';
$body_class = 'page page-auth page-login';
$current_page = 'login';

$page_css = ['auth.css'];
$page_scripts = ['auth.js'];

// If already authenticated, redirect to home
if (\App\Services\AuthService::check()) {
    header('Location: ' . $base_path . 'index.php');
    exit;
}

$error_message = '';
$form_errors = [];
$old_email = '';

// Handle Login Form Submission (AJAX & Standard POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || (isset($_SERVER['HTTP_ACCEPT']) && str_contains(strtolower($_SERVER['HTTP_ACCEPT']), 'application/json'))
        || isset($_POST['ajax']);

    $result = \App\Services\AuthService::login(
        (string) ($_POST['email'] ?? ''),
        (string) ($_POST['password'] ?? '')
    );

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($result['success'] ? 200 : 422);
        echo json_encode($result);
        exit;
    }

    if ($result['success']) {
        header('Location: ' . $base_path . 'index.php');
        exit;
    } else {
        $error_message = $result['message'];
        $form_errors = $result['errors'] ?? [];
        $old_email = (string) ($_POST['email'] ?? '');
    }
}

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
        <div id="auth-alert" class="auth-alert <?= !empty($error_message) ? 'alert-error show' : (isset($_GET['registered']) ? 'alert-success show' : (isset($_GET['reset']) ? 'alert-success show' : (isset($_GET['logged_out']) ? 'alert-info show' : ''))) ?>">
            <?php if (!empty($error_message)): ?>
                <i class="fas fa-exclamation-circle"></i> <span><?= e($error_message) ?></span>
            <?php elseif (isset($_GET['registered'])): ?>
                <i class="fas fa-check-circle"></i> <span>Your account has been created successfully. Please sign in with your credentials.</span>
            <?php elseif (isset($_GET['reset'])): ?>
                <i class="fas fa-check-circle"></i> <span>Your password has been updated successfully. Please sign in with your new password.</span>
            <?php elseif (isset($_GET['logged_out'])): ?>
                <i class="fas fa-info-circle"></i> <span>You have been logged out safely.</span>
            <?php endif; ?>
        </div>

        <!-- Login Form -->
        <form id="login-form" class="auth-form" action="<?= $base_path ?>pages/login.php" method="post" autocomplete="on" novalidate>
            <!-- 1. Email Address -->
            <div class="form-group">
                <label for="login-email">Email Address <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="email" id="login-email" name="email" required class="form-input <?= isset($form_errors['email']) ? 'is-invalid' : '' ?>" placeholder="e.g. client@loremipsum.com" autocomplete="email" value="<?= e($old_email) ?>">
                </div>
                <div class="field-error <?= isset($form_errors['email']) ? 'show' : '' ?>" id="error-login-email"><?= e($form_errors['email'] ?? '') ?></div>
            </div>

            <!-- 2. Password -->
            <div class="form-group">
                <label for="login-password">Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="login-password" name="password" required class="form-input <?= isset($form_errors['password']) ? 'is-invalid' : '' ?>" placeholder="Enter your password" autocomplete="current-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="field-error <?= isset($form_errors['password']) ? 'show' : '' ?>" id="error-login-password"><?= e($form_errors['password'] ?? '') ?></div>
            </div>

            <div class="auth-options">
                <label class="auth-remember">
                    <input type="checkbox" name="remember" id="remember-me" checked>
                    <span>Keep me signed in</span>
                </label>
                <a href="<?= $base_path ?>pages/forgot-password.php" class="auth-forgot-link">Forgot password?</a>
            </div>

            <button type="submit" id="login-submit-btn" class="auth-btn-submit">
                <span class="btn-text">Sign In</span>
                <i class="fas fa-arrow-right btn-icon" aria-hidden="true" style="font-size: 11px;"></i>
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
