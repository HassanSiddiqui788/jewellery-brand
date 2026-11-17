<?php
/**
 * Page: Logout
 * Destroys user session and logs out safely.
 */

declare(strict_types=1);

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../app/Services/AuthService.php';

\App\Services\AuthService::logout();

// Check if request was sent via AJAX
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    || (isset($_SERVER['HTTP_ACCEPT']) && str_contains(strtolower($_SERVER['HTTP_ACCEPT']), 'application/json'));

if ($isAjax) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => true,
        'message' => 'You have been logged out successfully.',
        'redirect' => '../index.php',
    ]);
    exit;
}

// Standard browser redirect
$redirect = !empty($_GET['redirect']) ? (string) $_GET['redirect'] : '../index.php';
if (!headers_sent()) {
    header('Location: ' . $redirect);
}
exit;
