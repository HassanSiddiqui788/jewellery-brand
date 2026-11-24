<?php
/**
 * Page: Register / Create Account – JARWAYA JEWELS
 * Dynamic Core PHP + MySQL Registration System
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../app/Services/RegistrationService.php';

$base_path = '../';
$page_title = 'Create an Account – JARWAYA JEWELS';
$body_class = 'page page-auth page-register';
$current_page = 'register';

$page_css = ['auth.css'];
$page_scripts = ['auth.js'];

$success_message = '';
$error_message = '';
$form_errors = [];
$old_inputs = [
    'full_name' => '',
    'email' => '',
];

// Handle Registration Form Submission (AJAX & Standard POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || (isset($_SERVER['HTTP_ACCEPT']) && str_contains(strtolower($_SERVER['HTTP_ACCEPT']), 'application/json'))
        || isset($_POST['ajax']);

    $result = \App\Services\RegistrationService::register($_POST);

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($result['success'] ? 200 : 422);
        echo json_encode($result);
        exit;
    }

    // Standard POST fallback (without JavaScript)
    if ($result['success']) {
        $success_message = $result['message'];
        $old_inputs = ['full_name' => '', 'email' => ''];
    } else {
        $error_message = $result['message'];
        $form_errors = $result['errors'] ?? [];
        $old_inputs = [
            'full_name' => (string) ($_POST['full_name'] ?? ''),
            'email' => (string) ($_POST['email'] ?? ''),
        ];
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="auth-wrapper">
    <div class="auth-card">
        <!-- Brand Header -->
        <header class="auth-header">
            <a href="<?= $base_path ?>index.php" class="auth-logo-link" aria-label="Home">
                <img src="<?= $base_path ?>assets/icons/logo.svg" alt="JARWAYA JEWELS" class="auth-logo-img">
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
        <div id="auth-alert" class="auth-alert <?= !empty($success_message) ? 'alert-success show' : (!empty($error_message) ? 'alert-error show' : '') ?>">
            <?php if (!empty($success_message)): ?>
                <i class="fas fa-check-circle"></i> <span><?= e($success_message) ?></span>
            <?php elseif (!empty($error_message)): ?>
                <i class="fas fa-exclamation-circle"></i> <span><?= e($error_message) ?></span>
            <?php endif; ?>
        </div>

        <!-- Dynamic Registration Form -->
        <form id="register-form" class="auth-form" action="<?= $base_path ?>pages/register.php" method="post" autocomplete="on" novalidate>
            <!-- 1. Full Name -->
            <div class="form-group">
                <label for="reg-full-name">Full Name <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="text" id="reg-full-name" name="full_name" required class="form-input <?= isset($form_errors['full_name']) ? 'is-invalid' : '' ?>" placeholder="e.g. Eleanor Vance" autocomplete="name" value="<?= e($old_inputs['full_name']) ?>">
                </div>
                <div class="field-error <?= isset($form_errors['full_name']) ? 'show' : '' ?>" id="error-full_name"><?= e($form_errors['full_name'] ?? '') ?></div>
            </div>

            <!-- 2. Email Address -->
            <div class="form-group">
                <label for="reg-email">Email Address <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="email" id="reg-email" name="email" required class="form-input <?= isset($form_errors['email']) ? 'is-invalid' : '' ?>" placeholder="e.g. client@loremipsum.com" autocomplete="email" value="<?= e($old_inputs['email']) ?>">
                </div>
                <div class="field-error <?= isset($form_errors['email']) ? 'show' : '' ?>" id="error-email"><?= e($form_errors['email'] ?? '') ?></div>
            </div>

            <!-- 3. Password -->
            <div class="form-group">
                <label for="reg-password">Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reg-password" name="password" minlength="8" required class="form-input <?= isset($form_errors['password']) ? 'is-invalid' : '' ?>" placeholder="At least 8 characters" autocomplete="new-password">
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
                <div class="field-error <?= isset($form_errors['password']) ? 'show' : '' ?>" id="error-password"><?= e($form_errors['password'] ?? '') ?></div>
            </div>

            <!-- 4. Confirm Password -->
            <div class="form-group">
                <label for="reg-confirm-password">Confirm Password <span style="color: var(--color-accent);">&bull;</span></label>
                <div class="input-wrap">
                    <input type="password" id="reg-confirm-password" name="confirm_password" minlength="8" required class="form-input <?= isset($form_errors['confirm_password']) ? 'is-invalid' : '' ?>" placeholder="Re-enter your password" autocomplete="new-password">
                    <button type="button" class="password-toggle-btn" aria-label="Show password" title="Toggle password visibility">
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="field-error <?= isset($form_errors['confirm_password']) ? 'show' : '' ?>" id="error-confirm_password"><?= e($form_errors['confirm_password'] ?? '') ?></div>
            </div>

            <!-- 5. Register Button -->
            <button type="submit" id="reg-submit-btn" class="auth-btn-submit">
                <span class="btn-text">Register</span>
                <i class="fas fa-arrow-right btn-icon" aria-hidden="true" style="font-size: 11px;"></i>
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
