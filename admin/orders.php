<?php
/**
 * Admin Page: Orders Management
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/../app/Services/OrderService.php';

use App\Services\OrderService;

$page_title = 'Orders';
$page_subtitle = 'Track Purchases & Fulfillment';
$active_nav = 'orders';

$dbOrders = [];
try {
    $rawDbOrders = OrderService::getAllOrders();
    foreach ($rawDbOrders as $dbOrd) {
        $formattedItems = [];
        if (!empty($dbOrd['items'])) {
            foreach ($dbOrd['items'] as $it) {
                $formattedItems[] = [
                    'name'  => $it['product_name'],
                    'qty'   => (int) $it['quantity'],
                    'price' => (float) $it['price'],
                    'image' => !empty($it['product_image']) ? $it['product_image'] : 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
                ];
            }
        }

        $addr = $dbOrd['shipping_address'];
        if (!empty($dbOrd['apartment'])) $addr .= ', ' . $dbOrd['apartment'];
        if (!empty($dbOrd['city'])) $addr .= ', ' . $dbOrd['city'];
        if (!empty($dbOrd['country'])) $addr .= ', ' . $dbOrd['country'];

        $dbOrders[] = [
            'id'             => $dbOrd['order_number'],
            'customer_id'    => $dbOrd['user_id'],
            'customer_name'  => $dbOrd['customer_name'],
            'customer_email' => $dbOrd['customer_email'],
            'customer_phone' => $dbOrd['customer_phone'],
            'shipping_addr'  => $addr,
            'date'           => date('Y-m-d', strtotime($dbOrd['created_at'])),
            'total'          => (float) $dbOrd['total_amount'],
            'subtotal'       => (float) $dbOrd['subtotal'],
            'shipping'       => (float) $dbOrd['shipping_fee'],
            'payment_status' => $dbOrd['payment_status'],
            'order_status'   => $dbOrd['order_status'],
            'items'          => $formattedItems,
        ];
    }
} catch (\Throwable $e) {
    // If DB read fails, fall through
}

$sampleOrders = get_sample_orders();
$orders = !empty($dbOrders) ? array_merge($dbOrders, $sampleOrders) : $sampleOrders;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Filter & Search Bar -->
<div class="page-action-bar">
    <div id="orderStatusFilters" class="filter-pills">
        <button type="button" class="filter-pill active" data-status="all">All Orders</button>
        <button type="button" class="filter-pill" data-status="Pending">Pending</button>
        <button type="button" class="filter-pill" data-status="Processing">Processing</button>
        <button type="button" class="filter-pill" data-status="Shipped">Shipped</button>
        <button type="button" class="filter-pill" data-status="Delivered">Delivered</button>
        <button type="button" class="filter-pill" data-status="Cancelled">Cancelled</button>
    </div>

    <div class="search-input-wrap" style="max-width: 280px;">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="text" id="orderSearch" class="search-input" placeholder="Search Order ID or customer..." />
    </div>
</div>

<!-- Orders Table Card -->
<section class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Customer Orders</h2>
            <div class="admin-card-subtitle">Click View Details to inspect ordered pieces and update status</div>
        </div>
        <span class="table-sub-text"><?= count($orders) ?> recent orders</span>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <?php foreach ($orders as $ord):
                    $pay_cls = ($ord['payment_status'] === 'Paid') ? 'badge-success' : (($ord['payment_status'] === 'Refunded') ? 'badge-neutral' : 'badge-warning');
                    $ord_cls = 'badge-warning';
                    if ($ord['order_status'] === 'Delivered') $ord_cls = 'badge-success';
                    elseif ($ord['order_status'] === 'Shipped') $ord_cls = 'badge-info';
                    elseif ($ord['order_status'] === 'Cancelled') $ord_cls = 'badge-danger';
                ?>
                    <tr data-id="<?= e_admin($ord['id']) ?>"
                        data-customer="<?= e_admin($ord['customer_name']) ?>"
                        data-status="<?= e_admin($ord['order_status']) ?>"
                        data-order="<?= e_admin(json_encode($ord)) ?>">
                        <td><strong><?= e_admin($ord['id']) ?></strong></td>
                        <td>
                            <span class="table-primary-text"><?= e_admin($ord['customer_name']) ?></span>
                            <span class="table-sub-text"><?= e_admin($ord['customer_email']) ?></span>
                        </td>
                        <td><?= e_admin($ord['date']) ?></td>
                        <td><strong><?= admin_currency($ord['total']) ?></strong></td>
                        <td><span class="badge <?= $pay_cls ?>"><?= e_admin($ord['payment_status']) ?></span></td>
                        <td class="order-status-cell"><span class="badge <?= $ord_cls ?>"><?= e_admin($ord['order_status']) ?></span></td>
                        <td>
                            <div class="table-actions">
                                <button type="button" class="btn btn-outline btn-sm btn-view-order">
                                    <i class="fas fa-eye" aria-hidden="true"></i> View Details
                                </button>
                                <button type="button" class="btn-icon delete btn-delete-order" title="Remove Order" aria-label="Remove Order">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="ordersEmptyState" class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-shopping-bag" aria-hidden="true"></i></div>
        <h3>No Matching Orders</h3>
        <p>There are no orders matching the selected status filter or search query.</p>
        <button type="button" id="resetOrderFiltersBtn" class="btn btn-outline btn-sm">Show All Orders</button>
    </div>
</section>

<!-- Order Details & Status Update Modal -->
<div id="orderDetailModal" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="orderDetailModalTitle" aria-hidden="true">
    <div class="admin-modal modal-lg">
        <div class="admin-modal-header">
            <div>
                <h2 id="orderDetailModalTitle" class="admin-modal-title">Order <span id="detailOrderId">#</span></h2>
                <div class="table-sub-text">Placed on <span id="detailOrderDate">—</span></div>
            </div>
            <button type="button" class="modal-close-btn" data-close-modal="orderDetailModal" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <div class="admin-modal-body">
            <div class="detail-meta-grid">
                <div>
                    <span class="detail-meta-label">Customer</span>
                    <span id="detailCustName" class="detail-meta-val">—</span>
                    <div id="detailCustContact" class="table-sub-text" style="margin-top: 3px;">—</div>
                </div>
                <div>
                    <span class="detail-meta-label">Shipping Address</span>
                    <span id="detailShippingAddr" class="detail-meta-val" style="font-weight: 500;">—</span>
                </div>
                <div>
                    <span class="detail-meta-label">Payment Status</span>
                    <span id="detailPaymentStatus" class="detail-meta-val">—</span>
                </div>
                <div>
                    <span class="detail-meta-label">Update Order Status</span>
                    <select id="detailOrderStatusSelect" class="form-control" style="padding: 8px 12px; margin-top: 4px;">
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <h3 style="font-size: 16px; margin-bottom: 12px;">Ordered Jewellery Pieces</h3>
            <div class="admin-table-wrap" style="border: 1px solid var(--color-border); border-radius: var(--radius-md);">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Piece</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="detailOrderItemsBody"></tbody>
                </table>
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 16px; margin-top: 18px;">
                <span class="table-sub-text" style="text-transform: uppercase; letter-spacing: 1px;">Order Total:</span>
                <strong id="detailOrderTotal" style="font-family: var(--font-serif-display); font-size: 24px; color: var(--color-primary);">$0.00</strong>
            </div>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn btn-outline btn-sm" data-close-modal="orderDetailModal">Close</button>
            <button type="button" id="saveOrderStatusBtn" class="btn btn-primary btn-sm">
                <i class="fas fa-check-circle" aria-hidden="true"></i> Update Order Status
            </button>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

