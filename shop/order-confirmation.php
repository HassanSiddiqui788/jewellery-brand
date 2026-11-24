<?php
/**
 * Page: Order Confirmation & Receipt – JARWAYA JEWELS
 * Displays the verified customer order saved in MySQL database with invoice details.
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

$base_path = '../';
$page_title = 'Order Confirmed – JARWAYA JEWELS';
$body_class = 'page page-order-confirmation';
$current_page = 'order_confirmation';
$page_css = ['checkout.css'];

$orderNumber = trim((string) ($_GET['order_number'] ?? $_GET['order_id'] ?? $_SESSION['latest_order_number'] ?? ''));
$order = null;

if (!empty($orderNumber)) {
    $order = OrderService::getOrder($orderNumber);
}

require_once __DIR__ . '/../includes/header.php';
?>

<style>
    .clr-white{
        color: white !important;
    }
</style>

<main id="main-content" class="order-confirmation-container">
    <?php if (!$order): ?>
        <div class="confirmation-card" style="text-align: center; padding: 60px 30px;">
            <div style="font-size: 48px; color: var(--color-accent); margin-bottom: 20px;">
                <i class="fas fa-search" aria-hidden="true"></i>
            </div>
            <h1 class="confirmation-title">Order Not Found</h1>
            <p class="confirmation-subtitle" style="margin-bottom: 30px;">We could not locate the details for this order. It may have expired or the link is invalid.</p>
            <a href="<?= $base_path ?>shop/collections/index.php" class="btn-browse-collections">
                <i class="fas fa-gem" aria-hidden="true"></i> Explore Collections
            </a>
        </div>
    <?php else: 
        $payLabels = [
            'cod'           => 'Cash on Delivery',
            'bank_transfer' => 'Direct Bank Transfer',
            'card'          => 'Credit / Debit Card',
        ];
        $paymentMethodLabel = $payLabels[$order['payment_method']] ?? ucfirst($order['payment_method']);
        $orderDate = date('F j, Y, g:i a', strtotime($order['created_at']));
    ?>
        <div class="confirmation-card">
            <!-- Header -->
            <div class="confirmation-header">
                <div class="confirmation-success-icon">
                    <i class="fas fa-check" aria-hidden="true"></i>
                </div>
                <h1 class="confirmation-title">Thank You For Your Order!</h1>
                <p class="confirmation-subtitle">
                    Your luxury order has been confirmed and registered in our database. We are carefully preparing your artisan pieces.
                </p>
            </div>

            <!-- Meta Strip -->
            <div class="confirmation-meta-grid">
                <div class="conf-meta-box">
                    <span>Order Number</span>
                    <strong><?= htmlspecialchars($order['order_number']) ?></strong>
                </div>
                <div class="conf-meta-box">
                    <span>Date Placed</span>
                    <strong><?= htmlspecialchars(date('M j, Y', strtotime($order['created_at']))) ?></strong>
                </div>
                <div class="conf-meta-box">
                    <span>Total Amount</span>
                    <strong style="color: var(--color-accent); font-size: 16px;"><?= format_price($order['total_amount']) ?></strong>
                </div>
                <div class="conf-meta-box">
                    <span>Payment Method</span>
                    <strong><?= htmlspecialchars($paymentMethodLabel) ?></strong>
                </div>
            </div>

            <!-- Customer & Shipping Summary Grid -->
            <div class="conf-details-grid">
                <div class="conf-detail-panel">
                    <h4><i class="fas fa-user" style="color: var(--color-accent); margin-right: 6px;"></i> Customer Details</h4>
                    <p style="margin: 0 0 6px 0; font-weight: 600; color: var(--color-primary);"><?= htmlspecialchars($order['customer_name']) ?></p>
                    <p style="margin: 0 0 6px 0; font-size: 13px; color: var(--color-muted);">
                        <i class="fas fa-envelope" style="width: 16px;"></i> <?= htmlspecialchars($order['customer_email']) ?>
                    </p>
                    <p style="margin: 0; font-size: 13px; color: var(--color-muted);">
                        <i class="fas fa-phone" style="width: 16px;"></i> <?= htmlspecialchars($order['customer_phone']) ?>
                    </p>
                </div>

                <div class="conf-detail-panel">
                    <h4><i class="fas fa-shipping-fast" style="color: var(--color-accent); margin-right: 6px;"></i> Delivery Address</h4>
                    <p style="margin: 0 0 4px 0; color: var(--color-text); font-size: 13px; line-height: 1.5;">
                        <?= htmlspecialchars($order['shipping_address']) ?>
                        <?php if (!empty($order['apartment'])): ?>
                            <br><?= htmlspecialchars($order['apartment']) ?>
                        <?php endif; ?>
                        <br><?= htmlspecialchars($order['city']) ?><?= !empty($order['state']) ? ', ' . htmlspecialchars($order['state']) : '' ?><?= !empty($order['postal_code']) ? ' ' . htmlspecialchars($order['postal_code']) : '' ?>
                        <br><strong><?= htmlspecialchars($order['country']) ?></strong>
                    </p>
                </div>
            </div>

            <!-- Ordered Pieces Table -->
            <h3 style="font-family: var(--font-serif); font-size: 18px; margin: 0 0 16px 0; color: var(--color-primary);">Ordered Pieces</h3>
            <table class="conf-items-table" aria-label="Order Items Summary">
                <thead>
                    <tr>
                        <th>Artisan Piece</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Unit Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($order['items'])): ?>
                        <?php foreach ($order['items'] as $item): 
                            $imgSrc = !empty($item['product_image']) ? $item['product_image'] : $base_path . 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg';
                            if (!str_starts_with($imgSrc, 'http') && !str_starts_with($imgSrc, '/') && !str_starts_with($imgSrc, '../')) {
                                $imgSrc = $base_path . $imgSrc;
                            }
                        ?>
                            <tr>
                                <td>
                                    <div class="conf-item-flex">
                                        <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="conf-item-img">
                                        <div>
                                            <strong style="display: block; color: var(--color-primary);"><?= htmlspecialchars($item['product_name']) ?></strong>
                                            <?php if (!empty($item['product_id'])): ?>
                                                <span style="font-size: 11px; color: var(--color-muted);">SKU: <?= htmlspecialchars($item['product_id']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: center; font-weight: 600;"><?= (int) $item['quantity'] ?></td>
                                <td style="text-align: right;"><?= format_price($item['price']) ?></td>
                                <td style="text-align: right; font-weight: 600; color: var(--color-primary);"><?= format_price($item['line_total']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Financial Breakdown -->
            <div style="max-width: 320px; margin-left: auto; border-top: 1px solid var(--color-border); padding-top: 14px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: var(--color-muted);">
                    <span>Subtotal:</span>
                    <strong style="color: var(--color-primary);"><?= format_price($order['subtotal']) ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: var(--color-muted);">
                    <span>Express Delivery:</span>
                    <span style="color: #2e7d32; font-weight: 600;">Complimentary</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px dashed var(--color-border); font-size: 18px; font-weight: 700; color: var(--color-primary);">
                    <span>Grand Total:</span>
                    <span style="font-family: var(--font-serif-display); font-size: 22px; color: var(--color-accent);"><?= format_price($order['total_amount']) ?></span>
                </div>
            </div>

            <?php if (!empty($order['notes'])): ?>
                <div style="margin-top: 24px; padding: 14px; background: #FAF8F5; border-radius: 4px; font-size: 13px; color: var(--color-muted);">
                    <strong style="color: var(--color-primary); display: block; margin-bottom: 4px;">Order Notes:</strong>
                    <?= nl2br(htmlspecialchars($order['notes'])) ?>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="conf-actions">
                <button type="button" onclick="window.print()" class="btn-browse-collections" style="background: transparent; color: var(--color-primary); border: 1px solid var(--color-primary);">
                    <i class="fas fa-print" aria-hidden="true"></i> Print Receipt
                </button>
                <a href="<?= $base_path ?>shop/collections/index.php" class="btn-browse-collections clr-white">
                    <i class="fas fa-gem" aria-hidden="true"></i> Continue Shopping
                </a>
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
// Clear shopping bag from localStorage upon viewing confirmation
try {
    localStorage.removeItem('bijoux_cart_items');
    document.querySelectorAll('.elementor-button-icon-qty').forEach(b => {
        b.textContent = '0';
        b.setAttribute('data-counter', '0');
    });
} catch (e) {}
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
