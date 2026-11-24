<?php

declare(strict_types=1);

/**
 * Endpoint: Process Customer Order Submission
 * Accepts POST submissions from shop/checkout.php, validates customer & cart data,
 * inserts into MySQL database via OrderService, and returns JSON or redirect.
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../app/Services/OrderService.php';

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    if (function_exists('app') && app()->has('session')) {
        app()->session()->start();
    } else {
        @session_start();
    }
}

use App\Services\OrderService;

// Ensure request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// Determine if client expects JSON response
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
    || (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'))
    || (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json'))
    || isset($_POST['ajax']);

// Parse incoming data (JSON body or $_POST)
$input = $_POST;
$rawBody = file_get_contents('php://input');
if (!empty($rawBody) && ($jsonDecoded = json_decode($rawBody, true)) && is_array($jsonDecoded)) {
    $input = array_merge($input, $jsonDecoded);
}

// Attach logged-in user ID if present
if (empty($input['user_id']) && !empty($_SESSION['user_id'])) {
    $input['user_id'] = (int) $_SESSION['user_id'];
}

// Create order
$result = OrderService::createOrder($input);

if ($result['success']) {
    $orderNumber = $result['order_number'];
    $redirectUrl = 'order-confirmation.php?order_number=' . urlencode($orderNumber);

    // Save recently placed order number in session for confirmation page access
    $_SESSION['latest_order_number'] = $orderNumber;

    if ($isAjax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success'      => true,
            'order_number' => $orderNumber,
            'order_id'     => $result['order_id'],
            'redirect_url' => $redirectUrl,
            'message'      => 'Your order has been placed successfully.',
        ]);
        exit;
    }

    header('Location: ' . $redirectUrl);
    exit;
}

// On validation / database failure
if ($isAjax) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'errors'  => $result['errors'] ?? ['general' => 'Failed to place order.'],
    ]);
    exit;
}

// Non-AJAX fallback
$_SESSION['checkout_errors'] = $result['errors'] ?? ['general' => 'Failed to place order.'];
$_SESSION['checkout_old'] = $input;
header('Location: checkout.php');
exit;
