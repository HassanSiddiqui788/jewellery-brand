<?php
/**
 * Admin Page: Customers Management
 */
require_once __DIR__ . '/includes/config.php';

$page_title = 'Customers';
$page_subtitle = 'Client Directory & Purchase History';
$active_nav = 'customers';

$customers = get_sample_customers();

require_once __DIR__ . '/includes/header.php';
?>

<!-- Search Bar -->
<div class="page-action-bar">
    <div class="search-input-wrap">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="text" id="customerSearch" class="search-input" placeholder="Search customer by name, email, or phone..." />
    </div>

    <span class="table-sub-text"><?= count($customers) ?> registered clients in preview</span>
</div>

<!-- Customers Table Card -->
<section class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Boutique Clients</h2>
            <div class="admin-card-subtitle">Inspect contact information, lifetime value, and order history</div>
        </div>
    </div>

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email &amp; Phone</th>
                    <th>Location</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="customersTableBody">
                <?php foreach ($customers as $cust):
                    $initials = strtoupper(substr($cust['name'], 0, 1) . (strpos($cust['name'], ' ') !== false ? substr(strrchr($cust['name'], ' '), 1, 1) : ''));
                    $search_blob = $cust['name'] . ' ' . $cust['email'] . ' ' . $cust['phone'] . ' ' . $cust['city'];
                ?>
                    <tr data-search="<?= e_admin($search_blob) ?>"
                        data-customer="<?= e_admin(json_encode($cust)) ?>">
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span class="admin-avatar" style="width: 36px; height: 36px; font-size: 13px; flex-shrink: 0;">
                                    <?= e_admin($initials) ?>
                                </span>
                                <div>
                                    <span class="table-primary-text"><?= e_admin($cust['name']) ?></span>
                                    <span class="table-sub-text">Joined <?= e_admin($cust['joined']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="table-primary-text" style="font-weight: 500;"><?= e_admin($cust['email']) ?></span>
                            <span class="table-sub-text"><?= e_admin($cust['phone']) ?></span>
                        </td>
                        <td><?= e_admin($cust['city']) ?></td>
                        <td><span class="badge badge-neutral"><?= (int)$cust['orders_count'] ?> order(s)</span></td>
                        <td><strong><?= admin_currency($cust['total_spent']) ?></strong></td>
                        <td>
                            <button type="button" class="btn btn-outline btn-sm btn-view-customer">
                                <i class="fas fa-eye" aria-hidden="true"></i> Details &amp; History
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="customersEmptyState" class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
        <h3>No Customers Found</h3>
        <p>No customer profiles match your search query.</p>
        <button type="button" id="resetCustomerSearchBtn" class="btn btn-outline btn-sm">Clear Search</button>
    </div>
</section>

<!-- Customer Details & Order History Modal -->
<div id="customerDetailModal" class="admin-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="custModalTitle" aria-hidden="true">
    <div class="admin-modal modal-lg">
        <div class="admin-modal-header">
            <div>
                <h2 id="custModalTitle" class="admin-modal-title"><span id="custDetailName">Customer Profile</span></h2>
                <div class="table-sub-text">Client Contact &amp; Order History</div>
            </div>
            <button type="button" class="modal-close-btn" data-close-modal="customerDetailModal" aria-label="Close">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>

        <div class="admin-modal-body">
            <div class="detail-meta-grid">
                <div>
                    <span class="detail-meta-label">Email Address</span>
                    <span id="custDetailEmail" class="detail-meta-val">—</span>
                </div>
                <div>
                    <span class="detail-meta-label">Phone Number</span>
                    <span id="custDetailPhone" class="detail-meta-val">—</span>
                </div>
                <div>
                    <span class="detail-meta-label">Default Shipping Address</span>
                    <span id="custDetailAddress" class="detail-meta-val" style="font-weight: 500;">—</span>
                </div>
                <div>
                    <span class="detail-meta-label">Lifetime Spend</span>
                    <span id="custDetailSpent" class="detail-meta-val" style="color: var(--color-accent-hover); font-size: 16px;">$0.00</span>
                    <span id="custDetailOrdersCount" class="table-sub-text" style="margin-left: 6px;"></span>
                </div>
            </div>

            <h3 style="font-size: 16px; margin-bottom: 12px;">Order History</h3>
            <div class="admin-table-wrap" style="border: 1px solid var(--color-border); border-radius: var(--radius-md);">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Pieces</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="custOrderHistoryBody"></tbody>
                </table>
            </div>
        </div>

        <div class="admin-modal-footer">
            <button type="button" class="btn btn-primary btn-sm" data-close-modal="customerDetailModal">Done</button>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

